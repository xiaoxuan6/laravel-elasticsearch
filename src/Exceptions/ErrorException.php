<?php

namespace Vinhson\Elasticsearch\Exceptions;

class ErrorException extends \Exception
{
    public static function make($code = 0, $message = '', \Throwable $previous = null): ErrorException
    {
        return new static($message, $code, $previous);
    }
}
