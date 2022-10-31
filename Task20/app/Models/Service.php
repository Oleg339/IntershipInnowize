<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Service extends Model
{
    use HasFactory;

    const SERVICES = ['Configure', 'Install', 'Delivery', 'Warranty'];

    protected $fillable = [
        'deadline',
        'cost',
        'type'
    ];

    protected $table = 'services';
}
