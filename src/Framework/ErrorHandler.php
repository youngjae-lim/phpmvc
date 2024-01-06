<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

use ErrorException;
use Framework\Exceptions\PageNotFoundException;
use Throwable;

class ErrorHandler
{
    /**
     * Handle errors and convert them to ErrorException instances.
     *
     * @param  int  $errno The level of the error raised
     * @param  string  $errstr The error message
     * @param  string  $errfile The filename that the error was raised in
     * @param  int  $errline The line number the error was raised at
     *
     * @throws ErrorException
     */
    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    /**
     * Handle exceptions.
     *
     * @param  Throwable  $exception The exception
     *
     * @throws Throwable
     */
    public static function handleException(Throwable $exception): void
    {

        // Set the error template page
        if ($exception instanceof PageNotFoundException) {
            http_response_code(404);
            $template = '404.php';
        } else {
            http_response_code(500);
            $template = '500.php';
        }

        if ($_ENV['SHOW_ERRORS']) {
            // Turn on error display
            ini_set('display_errors', '1');
        } else {
            // Turn off error display
            ini_set('display_errors', '0');

            // Log errors to a file
            ini_set('log_errors', '1');

            // Render the error page
            require dirname(__DIR__, 2)."/views/{$template}";
        }

        throw $exception;
    }
}
