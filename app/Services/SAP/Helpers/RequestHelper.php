<?php

namespace App\Services\SAP\Helpers;

use GuzzleHttp\Client;
use App\Services\SAP\Config\SAPConfig;
use App\Services\SAP\Exceptions\SAPException;
use Illuminate\Support\Facades\Log;

class RequestHelper
{
    /**
     * Membuat instance GuzzleHttp Client
     *
     * @return Client
     */
    public static function createClient(): Client
    {
        return new Client(SAPConfig::getClientOptions());
    }

    /**
     * Mendapatkan default headers untuk SAP API
     *
     * @param string $sessionId
     * @param int|null $pageSize
     * @return array
     */
    public static function getDefaultHeaders(string $sessionId, ?int $pageSize = null): array
    {
        $headers = [
            'Cookie' => 'B1SESSION=' . $sessionId,
            'Content-Type' => 'application/json',
        ];

        if ($pageSize !== null) {
            $headers['Prefer'] = 'odata.maxpagesize=' . $pageSize;
        } else {
            $headers['Prefer'] = 'odata.maxpagesize=1';
        }

        return $headers;
    }

    /**
     * Format ID untuk URL
     *
     * @param string|int $id
     * @return string
     */
    public static function formatId($id): string
    {
        if (!is_scalar($id)) {
            throw new \InvalidArgumentException('ID harus berupa string atau integer');
        }

        return is_numeric($id) ? $id : "'" . $id . "'";
    }

    /**
     * Log request error
     *
     * @param \Exception $e
     * @throws SAPException
     */
    public static function logError(\Exception $e): void
    {
        Log::error('SAP API Request Error', ['error' => $e->getMessage()]);
        throw new SAPException('SAP API request failed: ' . $e->getMessage());
    }
}
