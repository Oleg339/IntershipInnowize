<?php

namespace Model\Products;

require_once 'vendor/autoload.php';

use Model\ProductBuilder;

class LaptopBuilder implements ProductBuilder
{
    private Laptop $laptop;

    private $name;

    private $cost;

    private $manufacture;

    private $date;

    public function setName(string $name): LaptopBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function setCost(string $cost): LaptopBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setManufacture(string $manufacture): LaptopBuilder
    {
        $this->manufacture = $manufacture;

        return $this;
    }

    public function setDate(string $date): LaptopBuilder
    {
        $this->date = $date;

        return $this;
    }

    public function build(): LaptopBuilder
    {
        $this->laptop = new Laptop($this->name, $this->cost, $this->manufacture, $this->date);

        return $this;
    }

    public function get(): Laptop
    {
        return $this->laptop;
    }
}