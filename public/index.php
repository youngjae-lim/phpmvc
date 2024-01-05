<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

spl_autoload_register(function (string $className) {
    $className = str_replace('\\', '/', $className);

    require "../src/$className.php";
});

set_error_handler("Framework\ErrorHandler::handleError");

set_exception_handler("Framework\ErrorHandler::handleException");

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException("Malformed URL: '{$_SERVER['REQUEST_URI']}'");
}

$router = require '../config/routes.php';
$container = require '../config/services.php';

$dispatcher = new Framework\Dispatcher($router, $container);
$dispatcher->handle($path);
