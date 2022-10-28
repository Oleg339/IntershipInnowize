<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $data = DB::table('services')->get();

        $services = collect();

        foreach ($data as $item) {
            $services->push($item->type::where('id', $item->id)->get()->first());
        }

        return view('services.index', ['services' => $services, 'types' => Service::CHILDS]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cost' => 'required|integer|min:0',
            'deadline' => 'required|date',
            'type' => 'in:Configure,Delivery,Install,Maintenance'
        ]);

        $class = 'App\Models\Services\\' . $request->type;

        $class::create([
            'cost' => $request->cost,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('services');
    }

    public function edit($service)
    {
        $service = DB::table('services')->where('id', $service)->get()->first()
            ->type::where('id', $service)->get()[0];

        return view('services.edit', ['service' => $service]);
    }

    public function update(Request $request, $service)
    {
        $this->validate($request, [
            'cost' => 'required|integer|min:0',
            'deadline' => 'required|date'
        ]);

        $class = DB::table('services')->where('id', $service)->get()->first()->type;

        $class::where('id', $service)->update([
            'cost' => $request->cost,
            'deadline' => $request->deadline
        ]);

        return redirect()->route('services');
    }

    public function destroy($service)
    {
        DB::table('services')->where('id', $service)->get()->first()
            ->type::where('id', $service)->get()[0]->delete();

        return redirect()->route('services');
    }
}
