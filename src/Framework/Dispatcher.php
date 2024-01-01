<?php

namespace Framework;

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
        $controllerObj->$action();
    }
}
