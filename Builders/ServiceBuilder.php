<?php

namespace Model\Services;

require_once 'vendor/autoload.php';

use Model\Service;
use Model\ServiceBuilderInterface;

class ServiceBuilder implements ServiceBuilderInterface
{
    private $class;

    private Service $service;

    private $cost;

    private $deadline;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function setCost(string $cost): ServiceBuilder
    {
        $this->cost = $cost;

        return $this;
    }

    public function setDeadline(string $deadline): ServiceBuilder
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function build(): ServiceBuilder
    {
        $this->service = new $this->class($this->cost, $this->deadline);

        return $this;
    }

    public function get(): Service
    {
        return $this->service;
    }
}