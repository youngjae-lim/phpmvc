<?php

declare(strict_types=1);

namespace Framework;

class MiddlewareRequestHandler implements RequestHandlerInferface
{
    public function __construct(
        // The middlewares are grouped by priority
        private array $middlewares,
        // The controller request handler is used when there are no more middlewares to process
        private ControllerRequestHandler $controllerHandler
    ) {
    }

    /**
     * handle implements the RequestHandlerInferface
     * It processes the middlewares in order of priority
     * If there are no more middlewares, it lets the controller handle the request
     * and returns the response
     */
    public function handle(Request $request): Response
    {
        // Get the next middleware
        $middleware = array_shift($this->middlewares);

        // If there are no more middlewares, let the controller handle the request and return the response
        if ($middleware === null) {
            return $this->controllerHandler->handle($request);
        }

        // Inject the request object into the middleware and pass the middleware request handler to the middleware
        return $middleware->process($request, $this);
    }
}
