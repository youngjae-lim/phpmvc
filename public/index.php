<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require_once '../src/router.php';

$router = new Router;

$router->add('/home/index', ['controller' => 'home', 'action' => 'index']);
$router->add('/products', ['controller' => 'products', 'action' => 'index']);
$router->add('/', ['controller' => 'home', 'action' => 'index']);

$params = $router->match($path);

$action = $params['action'];
$controller = $params['controller'];

require_once "../src/controllers/$controller.php";

$controllerObj = new $controller;

$controllerObj->$action();
