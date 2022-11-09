<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\Filter;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Currency;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('delete', Service::class);

        $filter = new Filter();

        $services = $filter->run($request, Service::class)
            ->orderBy('cost')
            ->paginate(10);

        $usdRate = Currency::where('currency', 'usd')->first()->rate;

        return view('services.index', ['services' => $services, 'usdRate' => $usdRate]);
    }

    public function store(StoreServiceRequest $request)
    {
        $this->authorize('create', Service::class);

        Service::create($request->validated());

        return redirect()->route('services');
    }

    public function edit(Service $service)
    {
        $this->authorize('edit', Service::class);

        return view('services.edit', ['service' => $service]);
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->authorize('update', Service::class);

        $service->update($request->validated());

        return redirect()->route('services');
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', Service::class);

        $service->delete();

        return redirect()->route('services');
    }
}
