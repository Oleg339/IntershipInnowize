<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

abstract class Product extends Model
{
    use HasFactory;

    const PRODUCTS = ['Fridge', 'Phone', 'Laptop', 'TV'];

    protected $fillable = [
        'name',
        'company',
        'cost',
        'release_date'
    ];

    protected $table = 'products';

    /**
     * Create a new instance of the given model.
     *
     * @param array $attributes
     * @param bool $exists
     * @return static
     */
    public function newInstance($attributes = [], $exists = false)
    {
        // This method just provides a convenient way for us to generate fresh model
        // instances of this current model. It is particularly useful during the
        // hydration of new objects via the Eloquent query builder instances.

        $model = !isset($attributes['type']) ?
            new static($attributes) :
            new $attributes['type']($attributes);

        $model->exists = $exists;

        $model->setConnection(
            $this->getConnectionName()
        );

        $model->setTable($this->getTable());

        $model->mergeCasts($this->casts);

        $model->fill((array)$attributes);

        return $model;
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param array $attributes
     * @param string|null $connection
     * @return static
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $attributes = (array)$attributes;

        $model = $this->newInstance([
            'type' => $attributes['type'] ?? null
        ], true);

        $model->setRawAttributes(Arr::except($attributes, 'type'), true);

        $model->setConnection($connection ?: $this->getConnectionName());

        $model->fireModelEvent('retrieved', false);

        return $model;
    }
}
