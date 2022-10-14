<?php

namespace Controller;

require_once 'vendor/autoload.php';

use Model\ProductAbstract;
use Model\Products\TV;
use Task18\AuthChecker;
use Task18\TwigLoader;
use Task18\Validator;

class CheckoutController
{
    public function index($request, $errors = [])
    {
        $email = AuthChecker::getUserEmail($request->getSession());
        $products = ProductAbstract::Find('user_email', $email);

        echo TwigLoader::run()->render('Checkout.html', ['products' => $products, 'errors' => $errors]);
    }

    public function checkout($request)
    {
        var_dump($request->getPost());

        echo '8tyrdftghjk';
        $email = AuthChecker::getUserEmail($request->getSession());

        $validator = new Validator($request->get());

        $isValidate = $validator->validate([
            'name' => ['string', 'required'],
            'cost' => ['required', 'number'],
            'manufacture' => ['required', 'string'],
        ]);

        if(!$isValidate){
            return $this->index($request, $validator->getErrors());
        }

        if($request->get()['add_service'] === 'false')
        {
            $class = 'Model\\Products\\' . ucwords($request->get()['product']);
            $product = new $class($request->get());
            $product->save();

            return $this->index($request);
        }
    }
}