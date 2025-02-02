<?php

namespace App\Exceptions;

use App\Type\JsonResponseType;
use Exception;

class AppException extends Exception
{
    public $message;
    public $errors;
    public $code;
    public $httpCode;

    public function __construct($message, $code = JsonResponseType::ERROR, $errors = [], $httpCode = 400)
    {
        $this->message = $message;
        $this->errors = $errors;
        $this->code = $code;
        $this->httpCode = $httpCode;
    }
}
