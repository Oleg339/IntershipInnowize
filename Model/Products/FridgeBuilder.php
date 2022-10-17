<?php

namespace Model\Products;

require_once 'vendor/autoload.php';

use Model\ProductBuilder;

class FridgeBuilder implements ProductBuilder
{
    private Fridge $fridge;

    private $name;

    private $cost;

    private $manufacture;

    private $date;

    public function setName(string $name): FridgeBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function setCost(string $cost): FridgeBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setManufacture(string $manufacture): FridgeBuilder
    {
        $this->manufacture = $manufacture;

        return $this;
    }

    public function setDate(string $date): FridgeBuilder
    {
        $this->date = $date;
    }

    public function build(): FridgeBuilder
    {
        $this->fridge = new Fridge($this->name, $this->cost, $this->manufacture, $this->date);

        return $this;
    }

    public function get(): Fridge
    {
        return $this->fridge;
    }
}