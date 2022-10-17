<?php

namespace Model\Products;

require_once 'vendor/autoload.php';

use Model\ProductBuilder;

class PhoneBuilder implements ProductBuilder
{
    private Phone $phone;

    private $name;

    private $cost;

    private $manufacture;

    private $date;

    public function setName(string $name): PhoneBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function setCost(string $cost): PhoneBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setManufacture(string $manufacture): PhoneBuilder
    {
        $this->manufacture = $manufacture;

        return $this;
    }

    public function setDate(string $date): PhoneBuilder
    {
        $this->date = $date;

        return $this;
    }

    public function build(): PhoneBuilder
    {
        $this->phone = new Phone($this->name, $this->cost, $this->manufacture, $this->date);

        return $this;
    }

    public function get(): Phone
    {
        return $this->phone;
    }
}