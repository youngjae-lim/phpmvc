<?php

declare(strict_types=1);

namespace Framework;

class Response
{
    private string $body = '';

    private array $headers = [];

    /**
     * Add a redirect header to the response
     */
    public function redirect(string $url): void
    {
        $this->addHeader("Location: {$url}");
    }

    /**
     * Add a response header
     */
    public function addHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    /**
     * Set the response body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * Get the response body
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Send the response
     */
    public function send(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }

        echo $this->body;
    }
}
