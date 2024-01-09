<?php

declare(strict_types=1);

namespace Framework;

class Request
{
    public function __construct(
        public string $uri,
        public string $method,
        public array $get,
        public array $post,
        public array $files,
        public array $cookie,
        public array $server
    ) {

    }

    /**
     * Create a request object from the PHP superglobals and return it
     *
     * Access the request object like this:
     * $request = Request::createFromGlobals();
     * $request->uri
     * $request->method
     * $request->get
     * $request->post
     * $request->files
     * $request->cookie
     * $request->server
     */
    public static function createFromGlobals(): static
    {
        return new static(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD'],
            $_GET,
            $_POST,
            $_FILES,
            $_COOKIE,
            $_SERVER
        );
    }
}
