<?php

include_once('Router.php');

if (array_key_exists('id', $_COOKIE)) {
    session_id($_COOKIE['id']);
}

session_start();

$router = new Router();

$router->get('/', ['Controller\CheckoutController', 'index']);
$router->get('/banned', ['Controller\LoginController', 'banned']);
$router->get('/registration', ['Controller\RegistrationController', 'index']);
$router->post('/registration', ['Controller\RegistrationController', 'registration']);
$router->get('/login', ['Controller\LoginController', 'index']);
$router->post('/login', ['Controller\LoginController', 'login']);
$router->get('/checkout', ['Controller\CheckoutController', 'index']);
$router->post('/checkout', ['Controller\CheckoutController', 'checkout']);

$router->run();