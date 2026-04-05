<?php

namespace App\Exceptions;

use Exception;

class TransactionException extends Exception
{
    protected $transactionId;

    public function __construct($message = "Transaction processing failed", $transactionId = null, $code = 0, Exception $previous = null)
    {
        $this->transactionId = $transactionId;
        parent::__construct($message, $code, $previous);
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }
}