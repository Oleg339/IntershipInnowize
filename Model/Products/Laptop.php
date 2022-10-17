<?php

namespace Model\Products;

use Model\Product;

require_once 'vendor/autoload.php';

class Laptop extends Product
{
    protected $name;

    protected $cost;

    protected $manufacture;

    protected $date;

    public function __construct($name, $cost, $manufacture, $date)
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->manufacture = $manufacture;
        $this->date = $date;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getCost(): string
    {
        return $this->cost;
    }

    public function getManufacture(): string
    {
        return $this->manufacture;
    }
}