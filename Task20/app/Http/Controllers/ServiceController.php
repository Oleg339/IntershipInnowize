<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', ['services' => Service::all(), 'types' => Service::CHILDS]);
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

    public function edit(Service $service)
    {
        return view('services.edit', ['services' => Service::all(), 'service' => $service]);
    }

    public function update(Request $request, Service $service)
    {
        $this->validate($request, [
            'cost' => 'required|integer|min:0',
            'deadline' => 'required|date'
        ]);

        $class = $service::class;

        $class::where('id', $service->id)->update([
            'cost' => $request->cost,
            'deadline' => $request->deadline
        ]);

        return redirect()->route('services');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services');
    }
}
