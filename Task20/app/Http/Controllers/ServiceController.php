<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceFactory;
use App\Repositories\Repository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    private ServiceFactory $serviceFactory;

    public function __construct()
    {
        $this->serviceFactory = new ServiceFactory();
    }

    public function index()
    {
    return view('services.index', ['services' => $this->serviceFactory->all(), 'types' => Service::SERVICES]);
    }

    public function store(StoreServiceRequest $request)
    {
        $this->serviceFactory->create($request->validated());

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
