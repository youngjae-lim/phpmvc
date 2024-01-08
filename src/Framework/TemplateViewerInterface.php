<?php

declare(strict_types=1);

namespace Framework;

interface TemplateViewerInterface
{
    public function render(string $template, array $data = []): string|false;
}
