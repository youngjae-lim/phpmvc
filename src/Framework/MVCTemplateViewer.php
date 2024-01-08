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
        // Get the absolute path to the views folder.
        $views_dir = dirname(__DIR__, 2).'/views';

        // Get the template code.
        $code = file_get_contents("{$views_dir}/{$template}");

        // If the template extends another template, replace the blocks in the base template with the blocks from the child template.
        if (preg_match('#^{% extends "(?<template>.*)" %}#', $code, $matches) === 1) {
            // Get the base template code.
            $base = file_get_contents("{$views_dir}/{$matches['template']}");

            // Get the blocks from the child template.
            $blocks = $this->getBlocks($code);

            // Replace the blocks in the base template with the blocks from the child template.
            $code = $this->replaceYields($base, $blocks);
        }

        // Replace the {{ variable }} syntax with PHP code.
        $code = $this->replaceVariables($code);

        // Replace the {% code %} syntax with PHP code.
        $code = $this->replacePHP($code);

        // Extract the data so we can access it as variables,but don't overwrite
        extract($data, EXTR_SKIP);

        // Start output buffering.
        ob_start();

        // Execute the PHP code in the string.
        eval('?>'.$code);

        // Get the contents of the output buffer and end it.
        return ob_get_clean();
    }

    /**
     * Replace the {{ variable }} syntax with PHP code like <?= htmlspecialchars($variable) ?>.
     *
     * @param  string  $code The template code.
     * @return string The template code with the variables replaced with PHP code.
     */
    private function replaceVariables(string $code): string
    {
        return preg_replace("#{{\s*(\S+)\s*}}#", "<?= htmlspecialchars(\$$1 ?? '') ?>", $code);
    }

    /**
     * Replace the {% code %} syntax with PHP code like <?php code ?>.
     *
     * @param  string  $code The template code.
     * @return string The template code with the PHP code.
     */
    private function replacePHP(string $code): string
    {
        return preg_replace("#{%\s*(.+)\s*%}#", '<?php $1 ?>', $code);
    }

    /**
     * Get the blocks from the template.
     * The block syntax is {% block name %} content {% endblock %}.
     *
     * @param  string  $code The template code.
     * @return array The blocks.
     */
    private function getBlocks(string $code): array
    {
        $blocks = [];

        // s mode: . matches newlines
        // ? mode in the <content> catch-block: non-greedy - each endblock will match the closest block
        preg_match_all('#{% block (?<name>\w+) %}(?<content>.*?){% endblock %}#s', $code, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $blocks[$match['name']] = $match['content'];
        }

        return $blocks;
    }

    /**
     * Replace the {% yield name %} syntax with the block content.
     *
     * @param  string  $code The template code.
     * @param  array  $blocks The blocks.
     * @return string The template code with the blocks replaced.
     */
    private function replaceYields(string $code, array $blocks): string
    {
        preg_match_all('#{% yield (?<name>\w+) %}#', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $name = $match['name'];
            $block = $blocks[$name];
            $code = preg_replace("#{% yield $name %}#", $block, $code);
        }

        return $code;
    }
}
