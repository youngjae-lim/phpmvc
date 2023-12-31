<?php

namespace Framework;

class Router
{
    private array $routes = [];

    /**
     * Add a route to the routing table
     *
     * @param  string  $path The route URL
     * @param  array  $params Parameters (controller, action, etc.)
     */
    public function add(string $path, array $params = []): void
    {
        $this->routes[] = [
            'path' => $path,
            'params' => $params,
        ];
    }

    /**
     * Return the matched controller and action for the current request URL
     *
     * @param  string  $path The route URL
     */
    public function match(string $path): array|bool
    {
        $path = trim($path, '/');

        foreach ($this->routes as $route) {

            $pattern = $this->getPatternFromRoutePath($route['path']);

            if (preg_match($pattern, $path, $matches)) {
                // Get named capture group values
                $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $params = array_merge($matches, $route['params']);

                return $params;
            }
        }

        return false;
    }

    /**
     * Get regex pattern from route path
     *
     * @param  string  $path  Regex pattern
     */
    private function getPatternFromRoutePath(string $routePath): string
    {
        $routePath = trim($routePath, '/');

        $segments = explode('/', $routePath);

        // Convert route path segments to regex pattern
        // e.g. '/{controller}/{action}' => '(?<controller>[a-z]+)/(?<action>[a-z]+)'
        // e.g. '/products' => 'products'
        // e.g. '/home/index' => 'home/index'
        $segments = array_map(function (string $segment): string {
            if (preg_match("#^\{([a-z][a-z0-9]*)\}$#", $segment, $matches)) {
                $segment = '(?<'.$matches[1].'>[a-z]+)';
            }

            return $segment;
        }, $segments);

        return '#^'.implode('/', $segments).'$#';
    }
}
