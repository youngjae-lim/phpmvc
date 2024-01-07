<?php

declare(strict_types=1);

namespace Framework;

abstract class Controller
{
    protected Request $request;

    protected PHPTemplateViewer $viewer;

    /**
     * Set the request object
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * Set the viewer object
     */
    public function setViewer(PHPTemplateViewer $viewer): void
    {
        $this->viewer = $viewer;
    }
}
