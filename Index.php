<?php

use Task13\Router;

include_once('Router.php');

header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE');

$router = new Router();

$router->get('/', ['Controller\Api\UserApi', 'index']);
$router->get('/users', ['Controller\Api\UserApi', 'index']);
$router->get('/users/{id}', ['Controller\Api\UserApi', 'show']);
$router->get('/users/create', ['Controller\Api\UserApi', 'create']);
$router->get('/users/{id}/edit', ['Controller\Api\UserApi', 'edit']);
$router->post('/users', ['Controller\Api\UserApi', 'store']);
$router->put('/users/{id}', ['Controller\Api\UserApi', 'update']);
$router->patch('/users/{id}', ['Controller\Api\UserApi', 'update']);
$router->delete('/users/{id}', ['Controller\Api\UserApi', 'delete']);

$router->run();
