<?php

namespace Framework;

use ReflectionMethod;

class Dispatcher
{
    public function __construct(private Router $router)
    {
    }

    /**
     * Handle the request and call the appropriate controller action
     */
    public function handle(string $path): void
    {
        $params = $this->router->match($path);
        if (! $params) {
            echo '404 Not Found';
            exit;
        }
        $action = $params['action'];
        $controller = "App\Controllers\\".ucwords($params['controller']);
        $controllerObj = new $controller;

        $args = $this->getActionArguments($controller, $action, $params);

        $controllerObj->$action(...$args);
    }

    private function getActionArguments(string $controller, string $action, array $params): array
    {
        $args = [];

        $method = new ReflectionMethod($controller, $action);

        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();

            $args[$name] = $params[$name];
        }

        return $args;
    }
}
