<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\RequestHandlerInferface;
use Framework\Response;

class ChangeResponseExample
{
    /**
     * Add a string to the response body
     */
    public function process(Request $request, RequestHandlerInferface $next): Response
    {
        $response = $next->handle($request);

        $response->setBody($response->getBody().' hello from the middleware');

        return $response;
    }
}
