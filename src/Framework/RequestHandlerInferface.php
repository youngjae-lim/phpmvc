<?php

declare(strict_types=1);

namespace Framework;

interface RequestHandlerInferface
{
    public function handle(Request $request): Response;
}
