<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class SAPServices
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;
    protected Client $client;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('sap.sapb1.url', 'https://172.16.226.2:50000/b1s/v1'), '/') . '/';
        $this->username = config('sap.sapb1.username', env('SAP_USERNAME'));
        $this->password = config('sap.sapb1.password', env('SAP_PASSWORD'));

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'verify' => false, // Disable SSL verification for self-signed certificates
            'http_errors' => false, // Don't throw exceptions for HTTP errors
            // 'timeout' => 30,
        ]);
    }

    /**
     * Get default headers for SAP API requests
     * 
     * @return array
     */
    public function getDefaultHeaders(): array
    {
        return [
            'Cookie' => 'B1SESSION=' . session('sap_session_id'),
            'Content-Type' => 'application/json',
            'Prefer' => 'odata.maxpagesize=10',
        ];
    }

    public function handleRequest(callable $request)
    {
        $allData = [];
        try {
            // Ambil respons pertama
            $response = $request();
            $data = json_decode($response->getBody()->getContents(), true);

            // Gabungkan data dari respons pertama
            if (isset($data['value'])) {
                $allData = $data['value'];
            } else {
                $allData = $data;
            }

            // Jika ada lebih banyak data, ambil halaman berikutnya
            while (isset($data['@odata.nextLink'])) {
                $nextLink = $data['@odata.nextLink'];

                // Ambil data dari nextLink
                $response = $this->client->get($nextLink, [
                    'headers' => $this->getDefaultHeaders()
                ]);
                $data = json_decode($response->getBody()->getContents(), true);

                // Gabungkan data lebih lanjut
                $allData = array_merge($allData, $data['value']);
            }
        } catch (RequestException $e) {
            Log::error('SAP API Request gagal', [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);
            throw new \Exception('SAP API request gagal: ' . $e->getMessage());
        }
    }

    /**
     * Login to SAP B1
     * 
     * @param string $CompanyDB
     * @return bool|string True on success, error message on failure
     */
    public function login(string $CompanyDB)
    {
        try {
            $response = $this->client->post('Login', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'UserName' => $this->username,
                    'Password' => $this->password,
                    'CompanyDB' => $CompanyDB,
                ],
            ]);

            // Check status code
            $statusCode = $response->getStatusCode();
            if ($statusCode < 200 || $statusCode >= 300) {
                Log::error('SAP Login Failed', [
                    'statusCode' => $statusCode,
                    'response' => $response->getBody()->getContents()
                ]);
                return 'HTTP Error: ' . $statusCode;
            }

            // Parse response body
            $responseBody = $response->getBody()->getContents();
            $data = json_decode($responseBody, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('SAP Login - Invalid JSON response', ['response' => $responseBody]);
                return 'Invalid response from SAP';
            }

            // Check if session ID exists
            if (isset($data['SessionId'])) {
                session([
                    'sap_session_id' => $data['SessionId'],
                ]);
                return true;
            } else {
                Log::error('SAP Login - No SessionId in response', ['data' => $data]);
                return 'No session ID returned';
            }
        } catch (\Exception $e) {
            Log::error('SAP Login General Exception', [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            return 'Error: ' . $e->getMessage();
        }
    }

    public function get(string $endpoint, array $parameters = [])
    {
        return $this->handleRequest(function () use ($endpoint, $parameters) {
            return $this->client->get($endpoint, [
                'headers' => $this->getDefaultHeaders(),
                'query' => $parameters
            ]);
        });
    }

    public function getById(string $endpoint, string $id, array $parameters = [])
    {
        return $this->handleRequest(function () use ($endpoint, $id, $parameters) {
            return $this->client->get($endpoint . "('" . $id . "')", [
                'headers' => $this->getDefaultHeaders(),
                'query' => $parameters
            ]);
        });
    }

    public function post(string $endpoint, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $data) {
            return $this->client->post($endpoint, [
                'headers' => array_merge(
                    $this->getDefaultHeaders(),
                    ['Prefer' => 'return=representation']
                ),
                'json' => $data
            ]);
        });
    }

    public function put(string $endpoint, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $data) {
            return $this->client->put($endpoint, [
                'headers' => array_merge(
                    $this->getDefaultHeaders(),
                    ['Prefer' => 'return=representation']
                ),
                'json' => $data
            ]);
        });
    }

    public function patch(string $endpoint, string $id, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $id, $data) {
            return $this->client->patch($endpoint . "('" . $id . "')", [
                'headers' => array_merge(
                    $this->getDefaultHeaders(),
                    ['Prefer' => 'return=representation']
                ),
                'json' => $data
            ]);
        });
    }

    public function delete(string $endpoint, string $id)
    {
        return $this->handleRequest(function () use ($endpoint, $id) {
            return $this->client->delete($endpoint . "('" . $id . "')", [
                'headers' => $this->getDefaultHeaders()
            ]);
        });
    }

    /**
     * Logout from SAP B1
     * 
     * @return bool True on success, false on failure
     */
    public function logout()
    {
        try {
            if (!session()->has('sap_session_id')) {
                return true; // Already logged out
            }

            $response = $this->client->post('Logout', [
                'headers' => $this->getDefaultHeaders(),
            ]);

            // Even if logout fails, we'll clear the session
            session()->forget(['sap_session_id']);

            return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
        } catch (\Exception $e) {
            Log::error('SAP Logout Exception', [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

            // Still remove the session
            session()->forget(['sap_session_id']);

            return false;
        }
    }
}
