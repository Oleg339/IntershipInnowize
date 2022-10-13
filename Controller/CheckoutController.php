<?php

namespace Controller;

use Model\ProductAbstract;
use Task18\AuthChecker;

include_once('AuthChecker.php');

class CheckoutController
{
    public function index($request){
        $email = AuthChecker::getUserEmail($request->getSession());
        ProductAbstract::Find('email', $email);
    }
}