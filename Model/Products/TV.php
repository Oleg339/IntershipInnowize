<?php

namespace Model\Products;

use ProductAbstract;

class TV extends ProductAbstract
{
    const PRODUCT = 'TV';

    public function getProduct()
    {
        return self::PRODUCT;
    }
}