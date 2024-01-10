<?php

declare(strict_types=1);

namespace Framework;

class ControllerRequestHandler implements RequestHandlerInferface
{
    public function __construct(
        private Controller $controller,
        private string $action,
        private array $args)
    {
    }

    public function handle(Request $request): Response
    {
        // Inject the request object into the controller
        $this->controller->setRequest($request);

        return $this->controller->{$this->action}(...$this->args);
    }
}
