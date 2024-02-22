<?php

namespace App\Exceptions;

use Exception;

class MovieServiceUnavailableException extends Exception
{
    protected $code = 500;
    protected $message = "Service unavailable";
}
