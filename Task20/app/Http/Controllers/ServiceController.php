<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();

        return view('services.index', ['services' => $services]);
    }

    public function store(StoreServiceRequest $request)
    {
        Service::create($request->validated());

        return redirect()->route('services');
    }

    public function edit(Service $service)
    {
        return view('services.edit', ['service' => $service]);
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return redirect()->route('services');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services');
    }
}
