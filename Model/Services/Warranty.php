<?php

namespace Model\Services;

require_once 'vendor/autoload.php';

use Model\Service;

class Warranty extends Service
{
    private $deadline;

    private $cost;

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