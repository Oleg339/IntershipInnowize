<?php

namespace Model;

require_once 'vendor/autoload.php';

abstract class Service
{
    public abstract  function __construct($cost, $deadline);

    public abstract function getCost(): string;

    public abstract function getDeadline(): string;
}