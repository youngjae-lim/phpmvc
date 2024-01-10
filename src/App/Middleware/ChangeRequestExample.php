<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\RequestHandlerInferface;
use Framework\Response;

class ChangeRequestExample
{
    public function process(Request $request, RequestHandlerInferface $next): Response
    {
        // Trim all the post data
        $request->post = array_map('trim', $request->post);

        // Call the next middleware and get the response
        $response = $next->handle($request);

        return $response;
    }
}
