<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\PageNotFoundException;
use ReflectionMethod;

class Dispatcher
{
    public function __construct(private Router $router, private Container $container)
    {
    }

    /**
     * Handle the request and call the appropriate controller action
     */
    public function handle(string $path, string $method): void
    {
        $params = $this->router->match($path, $method);

        if (! $params) {
            throw new PageNotFoundException("No route matched for '$path' with method '$method'");
        }

        $controller = $this->getControllerName($params);
        $action = $this->getActionName($params);
        $args = $this->getActionArguments($controller, $action, $params);

        $controllerObj = $this->container->get($controller);

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
