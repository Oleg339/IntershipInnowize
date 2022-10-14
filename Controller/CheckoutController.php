<?php

namespace Controller;

require_once 'vendor/autoload.php';

use Model\ProductAbstract;
use Task18\AuthChecker;
use Task18\TwigLoader;
use Task18\Validator;

class CheckoutController
{
    public function index($request, $errors = [])
    {
        $email = AuthChecker::getUserEmail($request->getSession());
        $products = ProductAbstract::Find('user_email', $email);

        $total = 0;

        foreach ($products as $product) {
            $total += $product['cost'];

            if (isset($product['service'])) {
                $total += $product['service']['cost'];
            }
        }

        echo TwigLoader::run()->render('Checkout.html', ['products' => $products, 'errors' => $errors, 'total' => $total]);
    }

    public function checkout($request)
    {
        AuthChecker::getUserEmail($request->getSession());

        $validator = new Validator($request->get());

        $isValidate = $validator->validate([
            'name' => ['string', 'required'],
            'cost' => ['required', 'number'],
            'manufacture' => ['required', 'string'],
        ]);

        if (!$isValidate) {
            return $this->index($request, $validator->getErrors());
        }

        $class = 'Model\\Products\\' . ucwords($request->get()['product']);
        $product = new $class($request->get());

        if ($request->get()['add_service'] === 'false') {
            $product->save();

            return $this->index($request);
        }

        $isValidate = $validator->validate([
            'service' => ['required', 'string'],
            'deadline' => ['required'],
            'cost' => ['number']
        ]);

        if (!$isValidate) {
            return $this->index($request, $validator->getErrors());
        }

        $class = 'Model\\Service\\' . ucwords($request->get()['service']);
        $service = new $class($request->get());
        $product->addService($service->save()->getId())->save();

        return $this->index($request);
    }
}