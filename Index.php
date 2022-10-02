<?php

use Task13\Router;

include_once('Router.php');

if($url = parse_url($_SERVER['REQUEST_URI'])['path'] === '/'){
    include 'View/ListOfUsers.php';

    return;
}


header('Content-Type: application/json');

$router = new Router();

$router->get('/users', ['Controller\Api\UserController', 'index']);
$router->get('/users/{id}', ['Controller\Api\UserController', 'show']);
$router->get('/users/create', ['Controller\Api\UserController', 'create']);
$router->get('/users/{id}/edit', ['Controller\Api\UserController', 'edit']);
$router->post('/users', ['Controller\Api\UserController', 'store']);
$router->put('/users/{id}', ['Controller\Api\UserController', 'update']);
$router->patch('/users/{id}', ['Controller\Api\UserController', 'update']);
$router->delete('/users/{id}', ['Controller\Api\UserController', 'delete']);

$router->run();
