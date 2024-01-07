<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

// Define the root directory of the project.
define('ROOT_PATH', dirname(__DIR__));

spl_autoload_register(function (string $className) {
    // Replace the backslash (\) characters with forward slash (/) characters.
    // example: Framework\Router => Framework/Router
    $className = str_replace('\\', '/', $className);

    require ROOT_PATH."/src/$className.php";
});

$dotenv = new Framework\Dotenv();

$dotenv->load(ROOT_PATH.'/.env');

set_error_handler("Framework\ErrorHandler::handleError");

set_exception_handler("Framework\ErrorHandler::handleException");

$router = require ROOT_PATH.'/config/routes.php';
$container = require ROOT_PATH.'/config/services.php';

$dispatcher = new Framework\Dispatcher($router, $container);
$request = new Framework\Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$dispatcher->handle($request);
