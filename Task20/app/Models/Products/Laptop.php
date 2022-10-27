<?php

namespace App\Models\Products;

use App\Models\Product;
use App\Models\Child;

class Laptop extends Product
{
    use Child;
}
