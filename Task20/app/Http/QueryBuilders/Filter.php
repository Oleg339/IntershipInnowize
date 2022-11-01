<?php

namespace App\Http\QueryBuilders;

use Illuminate\Http\Request;

class Filter
{
    private $query;

    private $filters = ['type', 'minCost', 'maxCost'];

    public function run(Request $request, $class)
    {
        $this->query = $class::query();

        foreach ($this->filters as $filter) {
        if ($request->$filter && $request->$filter !== 'All') {
                $this->$filter($request->$filter);
            }
        }

        return $this->query;
    }

    public function type($type)
    {
        $this->query->where('type', '=', $type);
    }

    public function minCost($minCost)
    {
        $this->query->where('cost', '>=', $minCost);
    }

    public function maxCost($maxCost)
    {
        $this->query->where('cost', '<=', $maxCost);
    }
}
