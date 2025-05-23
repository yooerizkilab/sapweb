<?php

namespace App\Services\SAP\Config;

class SAPConfig
{
    /**
     * URL Base API SAP
     *
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return env('SAP_BASE_URL');
    }

    /**
     * Username SAP
     *
     * @return string
     */
    public static function getUsername(): string
    {
        return env('SAP_USERNAME');
    }

    /**
     * Password SAP
     *
     * @return string
     */
    public static function getPassword(): string
    {
        return env('SAP_PASSWORD');
    }

    /**
     * Mendapatkan HTTP Client options
     *
     * @return array
     */
    public static function getClientOptions(): array
    {
        return [
            'base_uri' => self::getBaseUrl(),
            'verify' => false, // Untuk self-signed SSL
            'http_errors' => false, // Jangan lempar exception jika HTTP error
        ];
    }

    /**
     * Mendapatkan timeout cache untuk session SAP
     *
     * @return int
     */
    public static function getSessionTimeout(): int
    {
        return 25; // 25 menit
    }

    /**
     * Mendapatkan default page size untuk SAP API
     *
     * @return int
     */
    public static function getDefaultPageSize(): int
    {
        return 1000;
    }
}
