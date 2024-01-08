<?php

$container = new Framework\Container;

// Register App\Database object in the container as a service
$container->set(App\Database::class, function () {
    return new App\Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
});

// Register Framework\PHPTemplateViewer object in the container as a service
// If you want to use MVCTemplateViewer instead, replace PHPTemplateViewer with MVCTemplateViewer
$container->set(Framework\TemplateViewerInterface::class, function () {
    return new Framework\PHPTemplateViewer;
});

return $container;
