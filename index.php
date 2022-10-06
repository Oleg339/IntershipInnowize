<?php

include_once('Router.php');

use Task17\Router;

$router = new Router();

$router->get('/registration', ['Controller\RegistrationController', 'index']);
$router->post('/registration', ['Controller\RegistrationController', 'registration']);

$router->run();