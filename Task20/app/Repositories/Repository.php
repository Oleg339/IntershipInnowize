<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Repository
{
    private string $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function all()
    {
        return $this->class::all();
    }

    public function get($id)
    {
        return $this->class::get()->first();
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function create(array $request)
    {
        return $this->class::create($request);
    }

    public function update(array $request, $entity)
    {
        $entity->update($request);
    }
}
