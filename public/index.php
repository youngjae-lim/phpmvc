<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require_once '../src/router.php';

$router = new Router;

$router->add('home/index', ['controller' => 'home', 'action' => 'index']);
$router->add('/products', ['controller' => 'products', 'action' => 'index']);
$router->add('/', ['controller' => 'home', 'action' => 'index']);

$params = $router->match($path);
exit(var_dump($params));

$segments = explode('/', $path);

$action = $segments[2];
$controller = $segments[1];

require_once "../src/controllers/$controller.php";

$controllerObj = new $controller;

$controllerObj->$action();
