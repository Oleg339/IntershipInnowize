<?php

include_once('Router.php');
use Task13\Router;

$router = new Router();

$router->get('/', ['Controller\FileController', 'upload']);
$router->get('/files', ['Controller\FileController', 'index']);
$router->post('/files', ['Controller\FileController', 'upload']);

$router->run();