<?php

namespace Model;

require_once 'vendor/autoload.php';

interface ProductBuilderInterface
{
    public function setName(string $name): ProductBuilderInterface;

    public function setCost(string $cost): ProductBuilderInterface;

    public function setManufacture(string $manufacture): ProductBuilderInterface;

    public function setDate(string $date): ProductBuilderInterface;

    public function build(): ProductBuilderInterface;

    public function get(): Product;
}