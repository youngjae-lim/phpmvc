<?php

declare(strict_types=1);

namespace Framework;

class MiddlewareRequestHandler implements RequestHandlerInferface
{
    public function __construct(
        private array $middlewares,
        private ControllerRequestHandler $controllerHandler
    ) {
    }

    public function handle(Request $request): Response
    {
        // TODO: Use the first middleware for now
        $middleware = $this->middlewares[0];

        return $middleware->process($request, $this->controllerHandler);
    }
}
