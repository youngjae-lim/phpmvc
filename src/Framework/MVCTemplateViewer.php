<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace Framework;

class MVCTemplateViewer implements TemplateViewerInterface
{
    /**
     * Render a template file.
     *
     * @param  string  $template The template file path, relative to the views folder.
     * @param  array  $data The data to pass to the template.
     * @return string|false The rendered template, or false if the template file doesn't exist.
     */
    public function render(string $template, array $data = []): string|false
    {
        // Extract the data so we can access it as variables,but don't overwrite
        extract($data, EXTR_SKIP);

        ob_start();

        require dirname(__DIR__, 2)."/views/{$template}";

        return ob_get_clean();
    }
}
