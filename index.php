<?php

include_once('Router.php');

use Task16\Router;

$router = new Router();

$router->get('/login', ['Controller\AuthController', 'index']);
$router->post('/login', ['Controller\AuthController', 'login']);

$router->run();