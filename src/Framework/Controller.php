<?php

declare(strict_types=1);

namespace Framework;

abstract class Controller
{
    protected Request $request;

    protected Response $response;

    protected TemplateViewerInterface $viewer;

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
    public function setViewer(TemplateViewerInterface $viewer): void
    {
        $this->viewer = $viewer;
    }

    /**
     * Set the response object
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }
}
