<?php

namespace Model\Products;

require_once 'vendor/autoload.php';

use Model\ProductBuilder;

class TVBuilder implements ProductBuilder
{
    private TV $tv;

    private $name;

    private $cost;

    private $manufacture;

    private $date;

    public function setName(string $name): TVBuilder
    {
        $this->name = $name;

        return $this;
    }

    public function setCost(string $cost): TVBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setManufacture(string $manufacture): TVBuilder
    {
        $this->manufacture = $manufacture;

        return $this;
    }

    public function setDate(string $date): TVBuilder
    {
        $this->date = $date;

        return $this;
    }

    public function build(): TVBuilder
    {
        $this->tv = new TV($this->name, $this->cost, $this->manufacture, $this->date);

        return $this;
    }

    public function get(): TV
    {
        return $this->tv;
    }
}