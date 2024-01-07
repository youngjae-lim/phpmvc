<?php

declare(strict_types=1);

namespace Framework;

abstract class Controller
{
    protected Request $request;

    /**
     * Set the request object
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
