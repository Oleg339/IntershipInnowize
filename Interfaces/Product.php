<?php

namespace Model;

require_once 'vendor/autoload.php';

abstract class Product
{
    public abstract function __construct($name, $cost, $manufacture, $date);

    public abstract function getName(): string;

    public abstract function getDate(): string;

    public abstract function getCost(): string;

    public abstract function getManufacture(): string;
}