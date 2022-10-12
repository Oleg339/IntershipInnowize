<?php

abstract class ProductAbstract implements ModelDB
{
    public function getTable()
    {
        return 'Products';
    }

    public abstract function getProduct();

    public abstract function getId();

    public abstract function getName();

    public abstract function getCost();

    public abstract function getManufacture();

    public abstract function getDate();
}