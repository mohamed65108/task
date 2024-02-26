<?php

namespace App\Exceptions;

use Exception;

class MovieServiceUnavailableException extends Exception
{
    protected $code = 503;

    protected $message = 'Service Unavailable';
}
