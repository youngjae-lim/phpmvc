<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

use ErrorException;

class ErrorHandler
{
    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}
