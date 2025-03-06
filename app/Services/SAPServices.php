<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SAPServices
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;
    protected Client $client;

    public function __construct()
    {
        $this->baseUrl = env('SAP_BASE_URL');
        $this->username = env('SAP_USERNAME');
        $this->password = env('SAP_PASSWORD');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'verify' => false, // Untuk self-signed SSL
            'http_errors' => false, // Jangan lempar exception jika HTTP error
        ]);
    }

    /**
     * Simpan session di cache berdasarkan user ID
     */
    private function getCacheKey(): string
    {
        $companyDB = session('sap_company_db');
        return "sap_session_" . Auth::id() . "_" . $companyDB;
    }

    public function getSessionId()
    {
        $cacheKey = $this->getCacheKey();
        return Cache::remember($cacheKey, now()->addMinutes(25), function () {
            return $this->login();
        });
    }

    public function refreshSAPSession()
    {
        $cacheKey = 'sap_session_' . auth()->id();

        if (Cache::has($cacheKey)) {
            // Perbarui waktu expired session setiap ada request baru
            Cache::put($cacheKey, Cache::get($cacheKey), now()->addMinutes(25));
        }
    }

    public function getDefaultHeaders(): array
    {
        return [
            'Cookie' => 'B1SESSION=' . $this->getSessionId(),
            'Content-Type' => 'application/json',
            'Prefer' => 'odata.maxpagesize=1000',
        ];
    }

    public function handleRequest(callable $request)
    {
        $this->refreshSAPSession(); // Perpanjang session jika masih valid

        try {
            $response = $request();
            $statusCode = $response->getStatusCode();
            $data = json_decode($response->getBody()->getContents(), true);

            if ($statusCode === 401) { // Session expired
                Log::warning('SAP session expired, relogging...');

                // Login ulang
                $companyDB = session('sap_company_db');
                $loginResult = $this->login($companyDB);

                if ($loginResult !== true) {
                    throw new \Exception('Re-login to SAP failed: ' . $loginResult);
                }

                // Coba request ulang
                $response = $request();
                $data = json_decode($response->getBody()->getContents(), true);
            }

            return $data['value'] ?? $data;
        } catch (\Exception $e) {
            Log::error('SAP API Request Error', ['error' => $e->getMessage()]);
            throw new \Exception('SAP API request failed: ' . $e->getMessage());
        }
    }

    public function login()
    {
        try {
            $cacheKey = $this->getCacheKey();
            $companyDB = session('sap_company_db'); // Ambil dari session

            if (!$companyDB) {
                throw new \Exception('CompanyDB tidak ditemukan, silakan login ulang.');
            }

            $response = $this->client->post('Login', [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => [
                    'UserName' => $this->username,
                    'Password' => $this->password,
                    'CompanyDB' => $companyDB,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['SessionId'])) {
                Cache::put($cacheKey, $data['SessionId'], now()->addMinutes(25));
                return true;
            }

            Log::error('SAP Login Gagal', ['data' => $data]);
            return 'Login ke SAP gagal, silakan coba lagi.';
        } catch (\Exception $e) {
            Log::error('SAP Login Exception', ['message' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    public function logout()
    {
        try {
            $cacheKey = $this->getCacheKey();
            $sessionId = Cache::get($cacheKey);

            if ($sessionId) {
                $this->client->post('Logout', ['headers' => $this->getDefaultHeaders()]);
                Cache::forget($cacheKey);
            }
        } catch (\Exception $e) {
            Log::error('SAP Logout Error', ['message' => $e->getMessage()]);
        }
    }

    // Fungsi GET
    public function get(string $endpoint, array $parameters = [])
    {
        return $this->handleRequest(function () use ($endpoint, $parameters) {
            return $this->client->get($endpoint, [
                'headers' => $this->getDefaultHeaders(),
                'query' => $parameters
            ]);
        });
    }

    // Fungsi GET by ID
    public function getById(string $endpoint, string $id, array $parameters = [])
    {
        // Validasi input
        if (!is_scalar($id)) {
            throw new \InvalidArgumentException('ID harus berupa string atau integer');
        }

        $formattedId = is_numeric($id)
            ? $id  // Untuk ID numerik, gunakan langsung
            : "'" . $id . "'";  // Untuk ID string, bungkus dengan single quote

        return $this->handleRequest(function () use ($endpoint, $formattedId, $parameters) {
            return $this->client->get($endpoint . "(" . $formattedId . ")", [
                'headers' => $this->getDefaultHeaders(),
                'query' => $parameters
            ]);
        });
    }

    // Fungsi POST
    public function post(string $endpoint, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $data) {
            return $this->client->post($endpoint, [
                'headers' => array_merge($this->getDefaultHeaders(), ['Prefer' => 'return=representation']),
                'json' => $data
            ]);
        });
    }

    // Fungsi PATCH
    public function patch(string $endpoint, string $id, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $id, $data) {
            return $this->client->patch("$endpoint('$id')", [
                'headers' => array_merge($this->getDefaultHeaders(), ['Prefer' => 'return=representation']),
                'json' => $data
            ]);
        });
    }

    // Fungsi DELETE
    public function delete(string $endpoint, string $id)
    {
        return $this->handleRequest(function () use ($endpoint, $id) {
            return $this->client->delete("$endpoint('$id')", [
                'headers' => $this->getDefaultHeaders()
            ]);
        });
    }
}
