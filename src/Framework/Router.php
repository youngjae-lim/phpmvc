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
    public function add(string $path, array $params): void
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
        $pattern = '#^/(?<controller>[a-z]+)/(?<action>[a-z]+)$#';

        if (preg_match($pattern, $path, $matches)) {
            $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

            return $matches;
        }

        return false;
    }
}
