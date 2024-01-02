<?php

namespace Framework;

class Viewer
{
    public function render(string $template, array $data = [])
    {
        // Extract the data so we can access it as variables,but don't overwrite
        extract($data, EXTR_SKIP);

        require_once "../views/{$template}";
    }
}
