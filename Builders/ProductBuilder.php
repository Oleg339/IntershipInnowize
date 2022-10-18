<?php

namespace Model\Products;

require_once 'vendor/autoload.php';

use Model\Product;
use Model\ProductBuilderInterface;

class ProductBuilder implements ProductBuilderInterface
{
    private $class;

    private Product $product;

    private $name;

    private $cost;

    private $manufacture;

    private $date;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function setName(string $name): ProductBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function setCost(string $cost): ProductBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setManufacture(string $manufacture): ProductBuilder
    {
        $this->manufacture = $manufacture;

        return $this;
    }

    public function setDate(string $date): ProductBuilder
    {
        $this->date = $date;

        return $this;
    }

    public function build(): ProductBuilder
    {
        $this->product = new $this->class($this->name, $this->cost, $this->manufacture, $this->date);

        return $this;
    }

    public function get(): Product
    {
        return $this->product;
    }
}