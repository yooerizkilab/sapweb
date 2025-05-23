<?php

namespace App\Services\SAP;

use App\Services\SAP\Contracts\SAPServiceInterface;
use App\Services\SAP\Exceptions\SAPAuthenticationException;
use App\Services\SAP\Exceptions\SAPException;
use App\Services\SAP\Helpers\CacheHelper;
use App\Services\SAP\Helpers\RequestHelper;
use App\Services\SAP\Helpers\ResponseHelper;
use App\Services\SAP\Config\SAPConfig;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SAPService implements SAPServiceInterface
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->client = RequestHelper::createClient();
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        return Cache::remember(
            CacheHelper::getSessionCacheKey(),
            now()->addMinutes(SAPConfig::getSessionTimeout()),
            function () {
                return $this->login();
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function refreshSAPSession()
    {
        CacheHelper::refreshSession();
    }

    /**
     * Mendapatkan default headers untuk request
     *
     * @param int|null $pageSize
     * @return array
     */
    public function getDefaultHeaders(?int $pageSize = null): array
    {
        return RequestHelper::getDefaultHeaders($this->getSessionId(), $pageSize);
    }

    /**
     * Handle request ke SAP
     *
     * @param callable $request
     * @return mixed
     * @throws SAPException
     */
    protected function handleRequest(callable $request)
    {
        $this->refreshSAPSession();

        try {
            $response = $request();
            $statusCode = $response->getStatusCode();
            $data = ResponseHelper::parseResponse($response);

            if (ResponseHelper::isUnauthorized($statusCode)) {
                Log::warning('SAP session expired, relogging...');

                // Login ulang
                $companyDB = session('sap_company_db');
                $loginResult = $this->login($companyDB);

                if ($loginResult !== true) {
                    throw new SAPAuthenticationException('Re-login to SAP failed: ' . $loginResult);
                }

                // Coba request ulang
                $response = $request();
                $data = ResponseHelper::parseResponse($response);
            }

            return $data;
        } catch (\Exception $e) {
            RequestHelper::logError($e);
            throw new SAPException('SAP API request failed: ' . $e->getMessage());
        }
    }

    /**
     * Login ke SAP
     *
     * @return mixed
     */
    public function login()
    {
        try {
            $companyDB = session('sap_company_db');

            if (!$companyDB) {
                throw new SAPAuthenticationException('CompanyDB tidak ditemukan, silakan login ulang.');
            }

            $response = $this->client->post('Login', [
                'headers' => ['Content-Type' => 'application/json'],
                'json' => [
                    'UserName' => SAPConfig::getUsername(),
                    'Password' => SAPConfig::getPassword(),
                    'CompanyDB' => $companyDB,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['SessionId'])) {
                CacheHelper::storeSession($data['SessionId']);
                return true;
            }

            ResponseHelper::logError('Login', $data);
            return 'Login ke SAP gagal, silakan coba lagi.';
        } catch (\Exception $e) {
            Log::error('SAP Login Exception', ['message' => $e->getMessage()]);
            return $e->getMessage();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function logout()
    {
        try {
            $sessionId = CacheHelper::getSession();

            if ($sessionId) {
                $this->client->post('Logout', ['headers' => $this->getDefaultHeaders()]);
                CacheHelper::forgetSession();
            }
        } catch (\Exception $e) {
            Log::error('SAP Logout Error', ['message' => $e->getMessage()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $endpoint, array $parameters = [], int $pageSize = 1000): array
    {
        $cacheKey = CacheHelper::generateRequestCacheKey($endpoint, $parameters);

        return Cache::remember($cacheKey, now()->addMinutes(SAPConfig::getSessionTimeout()), function () use ($endpoint, $parameters, $pageSize) {
            $allData = [];
            $skip = 0;

            do {
                $batchParams = array_merge($parameters, [
                    '$top' => $pageSize,
                    '$skip' => $skip,
                ]);

                $response = $this->handleRequest(function () use ($endpoint, $batchParams, $pageSize) {
                    return $this->client->get($endpoint, [
                        'headers' => array_merge($this->getDefaultHeaders(), [
                            'Prefer' => 'odata.maxpagesize=' . $pageSize,
                        ]),
                        'query' => $batchParams
                    ]);
                });

                $items = $response;
                $allData = array_merge($allData, $items);
                $fetchedCount = count($items);
                $skip += $fetchedCount;
            } while ($fetchedCount === $pageSize);

            return $allData;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function forgetCache($endpoint, $parameters)
    {
        CacheHelper::forgetRequestCache($endpoint, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getById(string $endpoint, string $id, array $parameters = [])
    {
        $formattedId = RequestHelper::formatId($id);

        return $this->handleRequest(function () use ($endpoint, $formattedId, $parameters) {
            return $this->client->get($endpoint . "(" . $formattedId . ")", [
                'headers' => $this->getDefaultHeaders(),
                'query' => $parameters
            ]);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $endpoint, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $data) {
            return $this->client->post($endpoint, [
                'headers' => array_merge($this->getDefaultHeaders(), ['Prefer' => 'return=representation']),
                'json' => $data
            ]);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function patch(string $endpoint, string $id, array $data)
    {
        $formattedId = RequestHelper::formatId($id);

        return $this->handleRequest(function () use ($endpoint, $formattedId, $data) {
            return $this->client->patch("$endpoint($formattedId)", [
                'headers' => array_merge($this->getDefaultHeaders(), ['Prefer' => 'return=representation']),
                'json' => $data
            ]);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $endpoint, string $id)
    {
        $formattedId = RequestHelper::formatId($id);

        return $this->handleRequest(function () use ($endpoint, $formattedId) {
            return $this->client->delete("$endpoint($formattedId)", [
                'headers' => $this->getDefaultHeaders()
            ]);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function crossJoin(array $entities, array $parameters = [], int $pageSize = 1000)
    {
        $crossJoin = '$crossjoin(' . implode(',', $entities) . ')';

        $allData = [];
        $skip = 0;

        do {
            $batchParams = array_merge($parameters, [
                '$top'  => $pageSize,
                '$skip' => $skip,
            ]);

            $response = $this->handleRequest(function () use ($crossJoin, $batchParams, $pageSize) {
                return $this->client->get($crossJoin, [
                    'headers' => array_merge($this->getDefaultHeaders(), [
                        'Prefer' => 'odata.maxpagesize=' . $pageSize,
                    ]),
                    'query' => $batchParams
                ]);
            });

            $items = $response;
            $allData = array_merge($allData, $items);
            $fetchedCount = count($items);
            $skip += $fetchedCount;
        } while ($fetchedCount === $pageSize);

        return $allData;
    }

    /**
     * {@inheritdoc}
     */
    public function crossJoinById(array $endpoint, string $id, array $parameters = [])
    {
        $formattedId = RequestHelper::formatId($id);
        $crossJoin = '$crossjoin(' . implode(',', $endpoint) . ')';

        return $this->handleRequest(function () use ($crossJoin, $formattedId, $parameters) {
            return $this->client->get($crossJoin . "(" . $formattedId . ")", [
                'headers' => $this->getDefaultHeaders(),
                'query' => $parameters
            ]);
        });
    }
}
