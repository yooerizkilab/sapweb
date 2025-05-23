<?php

namespace App\Services\SAP\Exceptions;

use Exception;

class SAPException extends Exception
{
    /**
     * Konstruktor
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = "SAP API Error", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
