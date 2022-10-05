<?php

include_once('Router.php');

use Task16\Router;

$router = new Router();

$router->get('/authentication', ['Controller\AuthController', 'index']);
$router->post('/authentication', ['Controller\AuthController', 'Authenticate']);
//$router->post('/files', ['Controller\FileController', 'upload']);

$router->run();