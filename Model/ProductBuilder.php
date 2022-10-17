<?php

namespace Model;

require_once 'vendor/autoload.php';

interface ProductBuilder
{
    public function setName(string $name): ProductBuilder;

    public function setCost(string $cost): ProductBuilder;

    public function setManufacture(string $manufacture): ProductBuilder;

    public function setDate(string $date): ProductBuilder;

    public function build(): ProductBuilder;

    public function get(): Product;
}