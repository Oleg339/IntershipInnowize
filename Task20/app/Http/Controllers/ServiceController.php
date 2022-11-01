<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\Filter;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $filter = new Filter();

        $services = $filter->run($request, Service::class)
            ->orderBy('cost')
            ->paginate(10);

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
