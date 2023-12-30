<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$segments = explode('/', $uri);

$action = $segments[2];
$controller = $segments[1];

require_once "../src/controllers/$controller.php";

$controllerObj = new $controller;

$controllerObj->$action();
