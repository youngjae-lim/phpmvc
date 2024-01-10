<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\PageNotFoundException;
use ReflectionMethod;
use UnexpectedValueException;

class Dispatcher
{
    public function __construct(
        private Router $router,
        private Container $container,
        private array $middlewareClasses = []
    ) {
    }

    /**
     * Handle the request and return a response
     */
    public function handle(Request $request): Response
    {
        $path = $this->getPath($request->uri);
        $params = $this->router->match($path, $request->method);

        if (! $params) {
            throw new PageNotFoundException("No route matched for '$path' with method '$request->method'");
        }

        $controller = $this->getControllerName($params);
        $action = $this->getActionName($params);
        $args = $this->getActionArguments($controller, $action, $params);

        // Get the controller object from the container
        $controllerObj = $this->container->get($controller);

        // Inject the response object into the controller
        $controllerObj->setResponse($this->container->get(Response::class));

        // Inject the viewer object into the controller
        $controllerObj->setViewer($this->container->get(TemplateViewerInterface::class));

        // Create a controller handler object with the controller object, action name, and arguments
        $controllerHandler = new ControllerRequestHandler($controllerObj, $action, $args);

        $middleware = $this->getMiddleware($params);

        print_r($middleware);
        exit;

        $middlewareHandler = new MiddlewareRequestHandler([$middleware], $controllerHandler);

        return $middlewareHandler->handle($request);

        // Call the controller handler's handle method and return the response
        // return $controllerHandler->handle($request);
    }

    /**
     * Get the middleware from the route params
     */
    private function getMiddleware(array $params): array
    {
        if (! array_key_exists('middleware', $params)) {
            return [];
        }

        $middleware = explode('|', $params['middleware']);

        return $middleware;
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

    /**
     * Get the path from the request URI
     */
    private function getPath(string $uri): string
    {

        $path = parse_url($uri, PHP_URL_PATH);

        if ($path === false) {
            throw new UnexpectedValueException("Malformed URL: '$uri");
        }

        return $path;
    }
}
