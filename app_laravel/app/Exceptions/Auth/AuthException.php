<?php

namespace App\Exceptions\Auth;

use Exception;

class AuthException extends Exception
{
    const INCORRECT_DATA = "Wrong email or password";

    private $mensaje;
    private $codigo;

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $this->mensaje = $message;
        $this->codigo = $code;

        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [code: {$this->code}] - [line: {$this->line}]: {$this->message}\n";
    }

    public function getCustomMessage()
    {
        return $this->mensaje;
    }

    public function getCustomCode()
    {
        return $this->codigo;
    }
}
