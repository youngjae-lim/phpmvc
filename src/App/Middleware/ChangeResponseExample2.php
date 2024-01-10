<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\RequestHandlerInferface;
use Framework\Response;

class ChangeResponseExample2
{
    /**
     * Add a string to the response body
     */
    public function process(Request $request, RequestHandlerInferface $next): Response
    {
        // Call the next middleware and get the response
        $response = $next->handle($request);

        $response->setBody($response->getBody().' hello from the middleware 2');

        return $response;
    }
}
