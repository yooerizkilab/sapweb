<?php

namespace App\Services\SAP\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Services\SAP\Config\SAPConfig;

class CacheHelper
{
    /**
     * Mendapatkan cache key berdasarkan user ID dan company database
     *
     * @return string
     */
    public static function getSessionCacheKey(): string
    {
        $companyDB = session('sap_company_db');
        return "sap_" . Auth::id() . "_" . $companyDB;
    }

    /**
     * Menghasilkan cache key untuk request data
     *
     * @param string $endpoint
     * @param array $parameters
     * @return string
     */
    public static function generateRequestCacheKey(string $endpoint, array $parameters): string
    {
        ksort($parameters);
        return 'sap_' . md5($endpoint . json_encode($parameters));
    }

    /**
     * Menyimpan session ID ke cache
     *
     * @param string $sessionId
     */
    public static function storeSession(string $sessionId): void
    {
        $cacheKey = self::getSessionCacheKey();
        Cache::put($cacheKey, $sessionId, now()->addMinutes(SAPConfig::getSessionTimeout()));
    }

    /**
     * Mendapatkan session ID dari cache
     *
     * @return string|null
     */
    public static function getSession(): ?string
    {
        return Cache::get(self::getSessionCacheKey());
    }

    /**
     * Refresh session (perpanjang waktu timeout)
     */
    public static function refreshSession(): void
    {
        $cacheKey = self::getSessionCacheKey();

        if (Cache::has($cacheKey)) {
            Cache::put($cacheKey, Cache::get($cacheKey), now()->addMinutes(SAPConfig::getSessionTimeout()));
        }
    }

    /**
     * Hapus session dari cache
     */
    public static function forgetSession(): void
    {
        Cache::forget(self::getSessionCacheKey());
    }

    /**
     * Hapus cache untuk request tertentu
     *
     * @param string $endpoint
     * @param array $parameters
     */
    public static function forgetRequestCache(string $endpoint, array $parameters): void
    {
        $cacheKey = self::generateRequestCacheKey($endpoint, $parameters);
        Cache::forget($cacheKey);
    }

    /**
     * Simpan response ke cache
     *
     * @param string $endpoint
     * @param array $parameters
     * @param mixed $data
     */
    public static function storeRequestCache(string $endpoint, array $parameters, $data): void
    {
        $cacheKey = self::generateRequestCacheKey($endpoint, $parameters);
        Cache::put($cacheKey, $data, now()->addMinutes(SAPConfig::getSessionTimeout()));
    }

    /**
     * Ambil data dari cache
     *
     * @param string $endpoint
     * @param array $parameters
     * @return mixed|null
     */
    public static function getRequestCache(string $endpoint, array $parameters)
    {
        $cacheKey = self::generateRequestCacheKey($endpoint, $parameters);
        return Cache::get($cacheKey);
    }

    /**
     * Cek apakah cache untuk request tertentu ada
     *
     * @param string $endpoint
     * @param array $parameters
     * @return bool
     */
    public static function hasRequestCache(string $endpoint, array $parameters): bool
    {
        $cacheKey = self::generateRequestCacheKey($endpoint, $parameters);
        return Cache::has($cacheKey);
    }
}
