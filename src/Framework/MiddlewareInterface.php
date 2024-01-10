<?php

namespace Framework;

/**
 * Interface MiddlewareInterface
 * Any middleware must implement this interface
 */
interface MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInferface $next): Response;
}
