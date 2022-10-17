<?php

namespace Model\Services;

require_once 'vendor/autoload.php';

use Model\ServiceBuilder;

class DeliveryBuilder implements ServiceBuilder
{
    private Delivery $delivery;

    private $cost;

    private $deadline;

    public function setCost(string $cost): DeliveryBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setDeadline(string $deadline): DeliveryBuilder
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function build(): DeliveryBuilder
    {
        $this->delivery = new Delivery($this->cost, $this->deadline);

        return $this;
    }

    public function get(): Delivery
    {
        return $this->delivery;
    }
}