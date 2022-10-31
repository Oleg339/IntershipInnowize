<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    const PRODUCTS = ['Fridge', 'Phone', 'Laptop', 'TV'];
    const TABLE = 'products';

    protected $fillable = [
        'name',
        'company',
        'cost',
        'release_date',
        'type'
    ];

    protected $table = 'products';
}
