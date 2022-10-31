<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Repositories\Repository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    private Repository $serviceRepository;

    public function __construct()
    {
        $this->serviceRepository = new Repository(Service::class);
    }

    public function index()
    {
    return view('services.index', ['services' => $this->serviceRepository->all(), 'types' => Service::SERVICES]);
    }

    public function store(StoreServiceRequest $request)
    {
        $this->serviceRepository->create($request->validated());

        return redirect()->route('services');
    }

    public function edit(Service $service)
    {
        return view('services.edit', ['service' => $service]);
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->serviceRepository->update($request->validated(), $service);

        return redirect()->route('services');
    }

    public function destroy(Service $service)
    {
        $this->serviceRepository->delete($service);

        return redirect()->route('services');
    }
}
