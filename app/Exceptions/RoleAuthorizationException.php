<?php

namespace App\Exceptions;

use Exception;

class RoleAuthorizationException extends Exception
{
    protected $requiredRole;
    protected $userRole;

    public function __construct($requiredRole, $userRole = null, $message = "Insufficient permissions", $code = 0, Exception $previous = null)
    {
        $this->requiredRole = $requiredRole;
        $this->userRole = $userRole;
        parent::__construct($message, $code, $previous);
    }

    public function getRequiredRole()
    {
        return $this->requiredRole;
    }

    public function getUserRole()
    {
        return $this->userRole;
    }
}