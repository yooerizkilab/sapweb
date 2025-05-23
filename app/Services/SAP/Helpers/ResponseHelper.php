<?php

namespace App\Services\SAP\Helpers;

use Illuminate\Support\Facades\Log;

class ResponseHelper
{
    /**
     * Parse response dari SAP API
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed
     */
    public static function parseResponse($response)
    {
        $data = json_decode($response->getBody()->getContents(), true);
        return $data['value'] ?? $data;
    }

    /**
     * Cek apakah status code adalah unauthorized (401)
     *
     * @param int $statusCode
     * @return bool
     */
    public static function isUnauthorized(int $statusCode): bool
    {
        return $statusCode === 401;
    }

    /**
     * Log response error
     *
     * @param string $action
     * @param array $data
     */
    public static function logError(string $action, array $data): void
    {
        Log::error('SAP ' . $action . ' Failed', ['data' => $data]);
    }
}
