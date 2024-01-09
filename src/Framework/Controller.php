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

    /**
     * Render a template and set it as the response body and return the response
     */
    protected function view(string $template, array $data = []): Response
    {
        $this->response->setBody($this->viewer->render($template, $data));

        return $this->response;
    }
}
