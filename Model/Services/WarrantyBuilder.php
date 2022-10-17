<?php

namespace Model\Services;

require_once 'vendor/autoload.php';

use Model\ServiceBuilder;

class WarrantyBuilder implements ServiceBuilder
{
    private Warranty $warranty;

    private $cost;

    private $deadline;

    public function setCost(string $cost): WarrantyBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setDeadline(string $deadline): WarrantyBuilder
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function build(): WarrantyBuilder
    {
        $this->warranty = new Warranty($this->cost, $this->deadline);

        return $this;
    }

    public function get(): Warranty
    {
        return $this->warranty;
    }
}