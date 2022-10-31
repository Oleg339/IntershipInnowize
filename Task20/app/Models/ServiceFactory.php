<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ServiceFactory
{
    public function create(array $request)
    {
        $class = 'App\Models\Services\\' . $request['type'];

        return $class::create($request);
    }

    public function all()
    {
        $data = DB::table('services')->get();

        $services = collect();

        foreach ($data as $item) {
            $services->push($item->type::where('id', $item->id)->get()[0]);
        }

        return $services;
    }
}

