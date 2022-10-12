<?php

namespace Model\Products;

use ProductAbstract;

class Fridge extends ProductAbstract
{
    const PRODUCT = 'Fridge';

    private $name;

    private $id;

    private $cost;

    private $date;

    private $manufactory;

    public function getProduct()
    {
        return self::PRODUCT;
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function getCost()
    {
        // TODO: Implement getCost() method.
    }

    public function getManufacture()
    {
        // TODO: Implement getManufacture() method.
    }

    public function getDate()
    {
        // TODO: Implement getDate() method.
    }
}