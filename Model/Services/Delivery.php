<?php

namespace Model\Services;

require_once 'vendor/autoload.php';

use Model\Service;

class Delivery extends Service
{
    private $cost;

    private $deadline;

    public function __construct($cost, $deadline)
    {
        $this->cost = $cost;
        $this->deadline = $deadline;
    }

    public function getCost(): string
    {
        return $this->cost;
    }

    public function getDeadline(): string
    {
        return $this->deadline;
    }
}