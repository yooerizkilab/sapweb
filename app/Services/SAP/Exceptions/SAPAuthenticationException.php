<?php

namespace App\Services\SAP\Exceptions;

use App\Services\SAP\Exceptions\SAPException;

class SAPAuthenticationException extends SAPException
{
    /**
     * Konstruktor
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message = "SAP Authentication Failed", int $code = 401, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
