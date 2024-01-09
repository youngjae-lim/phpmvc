<?php

declare(strict_types=1);

namespace Framework;

class Response
{
    private string $body = '';

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
        echo $this->body;
    }
}
