<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceRepository
{
    public function all()
    {
        $data = DB::table('services')->get();

        $services = collect();

        foreach ($data as $item) {
            $services->push($item->type::where('id', $item->id)->get()[0]);
        }

        return $services;
    }

    public function get($id)
    {
        return DB::table('services')->where('id', $id)->get()[0]
            ->type::where('id', $id)->get()[0];
    }

    public function delete($id)
    {
        return self::get($id)->delete();
    }

    private function getClass($id)
    {
        return DB::table('services')->where('id', $id)->get()->first()->type;
    }

    public function create(Request $request)
    {
        $class = 'App\Models\Services\\' . $request->type;

        return $class::create([
            'cost' => $request->cost,
            'deadline' => $request->deadline,
        ]);
    }

    public function update(Request $request, $id)
    {
        return $this->getClass($id)::where('id', $id)->update([
            'cost' => $request->cost,
            'deadline' => $request->deadline
        ]);
    }
}
