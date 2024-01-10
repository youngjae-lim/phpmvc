<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\MiddlewareInterface;
use Framework\Request;
use Framework\RequestHandlerInferface;
use Framework\Response;

class RedirectExample implements MiddlewareInterface
{
    public function __construct(private Response $response)
    {
    }

    /**
     * process implements MiddlewareInterface
     * Redirect to /products/index
     */
    public function process(Request $request, RequestHandlerInferface $next): Response
    {
        $this->response->redirect('/products/index');

        return $this->response;
    }
}
