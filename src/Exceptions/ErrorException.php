<?php
/**
 * This file is part of laravel-elasticsearch.
 *
 * (c) vinhson <15227736751@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vinhson\Elasticsearch\Exceptions;

use Exception;
use Throwable;

class ErrorException extends Exception
{
    public static function make($code = 0, $message = '', Throwable $previous = null): ErrorException
    {
        return new static($message, $code, $previous);
    }
}
