<?php

use Task13\Router;

include_once('Router.php');

$router = new Router();

$router->get('/', ['Api\UserApi', 'index']);
$router->get('/users', ['Api\UserApi', 'index']);
$router->get('/users/create', ['Api\UserApi', 'create']);
$router->get('/users/{id}/edit', ['Api\UserApi', 'edit']);
$router->post('/users', ['Api\UserApi', 'store']);
$router->put('/users/{id}', ['Api\UserApi', 'update']);
$router->delete('/users/{id}', ['Api\UserApi', 'delete']);

$router->run();
