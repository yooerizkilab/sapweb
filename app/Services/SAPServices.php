<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SAPServices
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;
    protected Client $client;

    /**
     * Konstruktor SAPServices
     */
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
        return "sap_" . Auth::id() . "_" . $companyDB;
    }

    /**
     * Dapatkan cache key untuk company tertentu
     */
    private function getCacheKeyForCompany(string $companyDB): string
    {
        return "sap_" . Auth::id() . "_" . $companyDB;
    }

    /**
     * Login ke SAP dan simpan session ke cache
     */
    public function getSessionId()
    {
        $cacheKey = $this->getCacheKey();
        return Cache::remember($cacheKey, now()->addMinutes(25), function () {
            return $this->login();
        });
    }

    /**
     * Dapatkan session ID untuk company tertentu
     */
    public function getSessionIdForCompany(string $companyDB)
    {
        $cacheKey = $this->getCacheKeyForCompany($companyDB);

        return Cache::remember($cacheKey, now()->addMinutes(25), function () use ($companyDB) {
            return $this->loginToCompany($companyDB);
        });
    }

    /**
     * Perbarui waktu expired session setiap ada request baru
     */
    public function refreshSAPSession()
    {
        $cacheKey = $this->getCacheKey();

        if (Cache::has($cacheKey)) {
            // Perbarui waktu expired session setiap ada request baru
            Cache::put($cacheKey, Cache::get($cacheKey), now()->addMinutes(25));
        }
    }

    /**
     * Perbarui waktu expired session untuk company tertentu
     */
    public function refreshSAPSessionForCompany(string $companyDB)
    {
        $cacheKey = $this->getCacheKeyForCompany($companyDB);

        if (Cache::has($cacheKey)) {
            // Perbarui waktu expired session
            Cache::put($cacheKey, Cache::get($cacheKey), now()->addMinutes(25));
        }
    }

    /**
     * Default headers untuk request ke SAP
     */
    public function getDefaultHeaders(): array
    {
        return [
            'Cookie' => 'B1SESSION=' . $this->getSessionId(),
            'Content-Type' => 'application/json',
            'Prefer' => 'odata.maxpagesize=1',
        ];
    }

    /**
     * Headers untuk request ke company tertentu
     */
    private function getHeadersForCompany(string $companyDB): array
    {
        $sessionId = $this->getSessionIdForCompany($companyDB);

        if (!$sessionId) {
            throw new \Exception("Tidak dapat login ke company: {$companyDB}");
        }

        return [
            'Cookie' => 'B1SESSION=' . $sessionId,
            'Content-Type' => 'application/json',
            'Prefer' => 'odata.maxpagesize=1',
        ];
    }

    /**
     * Handle Request ke SAP
     */
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

    /**
     * Handle Request ke SAP untuk company tertentu
     */
    public function handleRequestForCompany(callable $request, string $companyDB)
    {
        $this->refreshSAPSessionForCompany($companyDB); // Perpanjang session jika masih valid

        try {
            $response = $request();
            $statusCode = $response->getStatusCode();
            $data = json_decode($response->getBody()->getContents(), true);

            if ($statusCode === 401) { // Session expired
                Log::warning('SAP session untuk company lain expired, relogging...', ['companyDB' => $companyDB]);

                // Login ulang
                $loginResult = $this->loginToCompany($companyDB);

                if (!$loginResult) {
                    throw new \Exception('Re-login to SAP failed for company: ' . $companyDB);
                }

                // Coba request ulang
                $response = $request();
                $data = json_decode($response->getBody()->getContents(), true);
            }

            return $data['value'] ?? $data;
        } catch (\Exception $e) {
            Log::error('SAP API Request Error for Company', [
                'companyDB' => $companyDB,
                'error' => $e->getMessage()
            ]);
            throw new \Exception('SAP API request failed for company ' . $companyDB . ': ' . $e->getMessage());
        }
    }

    /**
     * Login ke SAP
     */
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

    /**
     * Login ke SAP dengan CompanyDB tertentu
     */
    public function loginToCompany(string $companyDB)
    {
        try {
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
                // Simpan session ID untuk company spesifik
                $cacheKey = $this->getCacheKeyForCompany($companyDB);
                Cache::put($cacheKey, $data['SessionId'], now()->addMinutes(25));
                return $data['SessionId'];
            }

            Log::error('SAP Login Gagal', ['data' => $data, 'companyDB' => $companyDB]);
            return false;
        } catch (\Exception $e) {
            Log::error('SAP Login Exception', ['message' => $e->getMessage(), 'companyDB' => $companyDB]);
            return false;
        }
    }

    /**
     * Logout dari SAP
     */
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

    /**
     * Logout dari SAP untuk company tertentu
     */
    public function logoutFromCompany(string $companyDB)
    {
        try {
            $cacheKey = $this->getCacheKeyForCompany($companyDB);
            $sessionId = Cache::get($cacheKey);

            if ($sessionId) {
                $this->client->post('Logout', ['headers' => $this->getHeadersForCompany($companyDB)]);
                Cache::forget($cacheKey);
            }
        } catch (\Exception $e) {
            Log::error('SAP Logout Error for Company', [
                'companyDB' => $companyDB,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function generateCacheKey($endpoint, $parameters)
    {
        ksort($parameters);
        return 'sap_' . md5($endpoint . json_encode($parameters));
    }

    /**
     * Fungsi GET All data
     */
    public function get(string $endpoint, array $parameters = [], int $pageSize = 1000): array
    {
        // caching data request
        $cacheKey = $this->generateCacheKey($endpoint, $parameters);

        return Cache::remember($cacheKey, now()->addMinutes(25), function () use ($endpoint, $parameters, $pageSize) {
            $allData = [];
            $skip = 0;

            do {
                $batchParams = array_merge($parameters, [
                    '$top' => $pageSize,
                    '$skip' => $skip,
                ]);

                $response = $this->handleRequest(function () use ($endpoint, $batchParams) {
                    return $this->client->get($endpoint, [
                        'headers' => array_merge($this->getDefaultHeaders(), [
                            'Prefer' => 'odata.maxpagesize=' . $batchParams['$top'],
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

    public function forgetCache($endpoint, $parameters)
    {
        $cacheKey = $this->generateCacheKey($endpoint, $parameters);
        Cache::forget($cacheKey);
    }

    /**
     * Fungsi GET ke database perusahaan lain
     */
    public function getOtherDB(string $companyDB, string $endpoint, array $parameters = [])
    {
        return $this->handleRequestForCompany(function () use ($companyDB, $endpoint, $parameters) {
            return $this->client->get($endpoint, [
                'headers' => $this->getHeadersForCompany($companyDB),
                'query' => $parameters
            ]);
        }, $companyDB);
    }

    /**
     * Fungsi GET by ID
     */
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

    /**
     * Fungsi GET by ID ke database perusahaan lain
     */
    public function getByIdOtherDB(string $companyDB, string $endpoint, string $id, array $parameters = [])
    {
        // Validasi input
        if (!is_scalar($id)) {
            throw new \InvalidArgumentException('ID harus berupa string atau integer');
        }

        $formattedId = is_numeric($id)
            ? $id  // Untuk ID numerik, gunakan langsung
            : "'" . $id . "'";  // Untuk ID string, bungkus dengan single quote

        return $this->handleRequestForCompany(function () use ($companyDB, $endpoint, $formattedId, $parameters) {
            return $this->client->get($endpoint . "(" . $formattedId . ")", [
                'headers' => $this->getHeadersForCompany($companyDB),
                'query' => $parameters
            ]);
        }, $companyDB);
    }

    /**
     * Fungsi POST
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
     * Fungsi POST ke database perusahaan lain
     */
    public function postOtherDB(string $companyDB, string $endpoint, array $data)
    {
        return $this->handleRequestForCompany(function () use ($companyDB, $endpoint, $data) {
            return $this->client->post($endpoint, [
                'headers' => array_merge($this->getHeadersForCompany($companyDB), ['Prefer' => 'return=representation']),
                'json' => $data
            ]);
        }, $companyDB);
    }

    /**
     * Fungsi PATCH
     */
    public function patch(string $endpoint, string $id, array $data)
    {
        return $this->handleRequest(function () use ($endpoint, $id, $data) {
            return $this->client->patch("$endpoint('$id')", [
                'headers' => array_merge($this->getDefaultHeaders(), ['Prefer' => 'return=representation']),
                'json' => $data
            ]);
        });
    }

    /**
     * Fungsi PATCH ke database perusahaan lain
     */
    public function patchOtherDB(string $companyDB, string $endpoint, string $id, array $data)
    {
        return $this->handleRequestForCompany(function () use ($companyDB, $endpoint, $id, $data) {
            return $this->client->patch("$endpoint('$id')", [
                'headers' => array_merge($this->getHeadersForCompany($companyDB), ['Prefer' => 'return=representation']),
                'json' => $data
            ]);
        }, $companyDB);
    }

    /**
     * Fungsi DELETE
     */
    public function delete(string $endpoint, string $id)
    {
        return $this->handleRequest(function () use ($endpoint, $id) {
            return $this->client->delete("$endpoint('$id')", [
                'headers' => $this->getDefaultHeaders()
            ]);
        });
    }

    /**
     * Fungsi DELETE ke database perusahaan lain
     */
    public function deleteOtherDB(string $companyDB, string $endpoint, string $id)
    {
        return $this->handleRequestForCompany(function () use ($companyDB, $endpoint, $id) {
            return $this->client->delete("$endpoint('$id')", [
                'headers' => $this->getHeadersForCompany($companyDB)
            ]);
        }, $companyDB);
    }

    /**
     * Fungsi Cross Join 
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

            $response = $this->handleRequest(function () use ($crossJoin, $batchParams) {
                return $this->client->get($crossJoin, [
                    'headers' => array_merge($this->getDefaultHeaders(), [
                        'Prefer' => 'odata.maxpagesize=' . $batchParams['$top'],
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
     * Fungsi Cross Join ke database perusahaan lain
     */
    public function crossJoinOtherDB(string $companyDB, array $endpoint, array $parameters = [])
    {
        $crossJoin = '$crossjoin(' . implode(',', $endpoint) . ')';

        return $this->handleRequestForCompany(function () use ($companyDB, $crossJoin, $parameters) {
            return $this->client->get($crossJoin, [
                'headers' => $this->getHeadersForCompany($companyDB),
                'query' => $parameters
            ]);
        }, $companyDB);
    }

    /**
     * Fungsi Cross Join by ID
     */
    public function crossJoinById(array $endpoint, string $id, array $parameters = [])
    {
        // Validasi input
        if (!is_scalar($id)) {
            throw new \InvalidArgumentException('ID harus berupa string atau integer');
        }

        $formattedId = is_numeric($id)
            ? $id  // Untuk ID numerik, gunakan langsung
            : "'" . $id . "'";  // Untuk ID string, bungkus dengan single quote

        $crossJoin = '$crossjoin(' . implode(',', $endpoint) . ')';

        return $this->handleRequest(function () use ($crossJoin, $formattedId, $parameters) {
            return $this->client->get($crossJoin . "('" . $formattedId . "')", [
                'headers' => $this->getDefaultHeaders(),
                'query' => $parameters
            ]);
        });
    }

    /**
     * Fungsi Cross Join by ID ke database perusahaan lain
     */
    public function crossJoinByIdOtherDB(string $companyDB, array $endpoint, string $id, array $parameters = [])
    {
        // Validasi input
        if (!is_scalar($id)) {
            throw new \InvalidArgumentException('ID harus berupa string atau integer');
        }

        $formattedId = is_numeric($id)
            ? $id  // Untuk ID numerik, gunakan langsung
            : "'" . $id . "'";  // Untuk ID string, bungkus dengan single quote

        $crossJoin = '$crossjoin(' . implode(',', $endpoint) . ')';

        return $this->handleRequestForCompany(function () use ($companyDB, $crossJoin, $formattedId, $parameters) {
            return $this->client->get($crossJoin . "('" . $formattedId . "')", [
                'headers' => $this->getHeadersForCompany($companyDB),
                'query' => $parameters
            ]);
        }, $companyDB);
    }
}
