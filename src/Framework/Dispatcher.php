<?php

namespace Framework;

use ReflectionClass;
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
        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);

        $reflector = new ReflectionClass($controller);
        $constructor = $reflector->getConstructor();

        $dependencies = [];

        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $parameter) {
                $type = (string) $parameter->getType();

                $dependencies[] = new $type;

            }
        }

        $controllerObj = new $controller(...$dependencies);

        $args = $this->getActionArguments($controller, $action, $params);

        $controllerObj->$action(...$args);
    }

    /**
     * Get the arguments for the controller action
     */
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

    /**
     * Convert the route controller name to a class name (StudlyCpas)
     *
     * Example: my-controller => MyController
     */
    private function getControllerName(array $params): string
    {
        $controller = $params['controller'];

        $controller = str_replace('-', '', ucwords(strtolower($controller), '-'));

        $namespace = "App\Controllers";

        if (array_key_exists('namespace', $params)) {
            $namespace .= '\\'.$params['namespace'];
        }

        return $namespace.'\\'.$controller;
    }

    /**
     * Convert the route action name to a method name (camelCase)
     *
     * Example: index => index
     * Example: add-new => addNew
     * Example: show-all => showAll
     */
    private function getActionName(array $params): string
    {
        $action = $params['action'];

        return lcfirst(str_replace('-', '', ucwords(strtolower($action), '-')));

    }
}
