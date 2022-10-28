<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    private ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        return view('services.index', ['services' => $this->serviceRepository->all(), 'types' => Service::CHILDS]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cost' => 'required|integer|min:0',
            'deadline' => 'required|date',
            'type' => 'in:Configure,Delivery,Install,Warranty'
        ]);

        $this->serviceRepository->create($request);

        return redirect()->route('services');
    }

    public function edit($serviceId)
    {
        return view('services.edit', ['service' => $this->serviceRepository->get($serviceId)]);
    }

    public function update(Request $request, $serviceId)
    {
        $this->validate($request, [
            'cost' => 'required|integer|min:0',
            'deadline' => 'required|date'
        ]);

        $this->serviceRepository->update($request, $serviceId);

        return redirect()->route('services');
    }

    public function destroy($serviceId)
    {
        $this->serviceRepository->delete($serviceId);

        return redirect()->route('services');
    }
}
