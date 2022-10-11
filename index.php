<?php

include_once('Router.php');

use Task18\Router;

if (array_key_exists('id', $_COOKIE)) {
    session_id($_COOKIE['id']);
}

session_start();

$router = new Router();

$router->get('/', ['Controller\FileController', 'index']);
$router->get('/banned', ['Controller\LoginController', 'banned']);
$router->get('/registration', ['Controller\RegistrationController', 'index']);
$router->post('/registration', ['Controller\RegistrationController', 'registration']);
$router->get('/login', ['Controller\LoginController', 'index']);
$router->post('/login', ['Controller\LoginController', 'login']);
$router->get('/files', ['Controller\FileController', 'index']);
$router->post('/files', ['Controller\FileController', 'upload']);

$router->run();