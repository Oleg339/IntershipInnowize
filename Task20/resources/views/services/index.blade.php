@extends('layouts.app')
@section('content')
    <div class="flex justify-center p-6">
        <div class="shadow-xl text-center p-6 w-8/12 bg-white rounded-lg">
            <form action="{{route('services')}}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="cost"></label>
                    <input type="number" name="cost" id="cost" placeholder="Cost"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('cost') border-red-500"
                           value="{{old('cost')}} @enderror">
                    @error('cost')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="deadline"></label>
                    <input type="date" name="deadline" id="deadline" placeholder="DeadLine"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('deadline') border-red-500 @enderror"
                           value="{{old('deadline')}}">
                    @error('deadline')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="type">
                        <select name="type" id="type" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                            <option value="Configure">
                                Configure
                            </option>
                            <option value="Delivery">
                                Delivery
                            </option>
                            <option value="Install">
                                Install
                            </option>
                            <option value="Warranty">
                                Warranty
                            </option>
                        </select>
                    </label>
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 px-4 py-3 text-white rounded font-medium w-full"> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
    <form action="{{route('services')}}" method="get">
        <div class="flex justify-center p-3">
            <div class="shadow-xl p-6 w-8/12 bg-white rounded-lg">
                <label for="order">
                    Order By:
                    <select name="order" id="order" class="bg-gray-100 border-2 p-3 rounded-lg">
                        <option value="cost">
                            Cost
                        </option>
                    </select>
                </label>
                <label for="minCost"></label>
                <input type="number" name="minCost" id="minCost" placeholder="Min Cost BYN"
                       class="bg-gray-100 border p-2 rounded-lg">
                <label for="maxCost"></label>
                <input type="number" name="maxCost" id="maxCost" placeholder="Max Cost BYN"
                       class="bg-gray-100 border p-2 rounded-lg">
                <label for="type" class="p-4">
                    <select name="type" id="type" class="bg-gray-100 border-2 p-3 rounded-lg">
                        <option value="Install">
                            Install
                        </option>
                        <option value="Configure">
                            Configure
                        </option>
                        <option value="Warranty">
                            Warranty
                        </option>
                        <option value="Delivery">
                            Delivery
                        </option>
                        <option value="All">
                            All
                        </option>
                    </select>
                </label>
                <button type="submit" class="bg-blue-500 px-4 py-3 text-white rounded font-medium"> Submit
                </button>
            </div>
        </div>
    </form>
    @if($services->count())
        @foreach($services as $service)
            <div class="flex justify-center p-3">
                <div class="p-6 shadow-xl p-1 w-8/12 bg-white rounded-lg">
                    <div class="mb-4">
                        <p class="font-bold">{{$service->type}}</p>
                        <p class="mb-2">Cost: {{$service->cost}} BYN | {{round($service->cost / $usdRate, 2)}} USD</p>
                        <span class="~text-gray-500 text-sm">DeadLine: {{substr($service->deadline, 0, 10)}}</span>
                        <div>
                            <form action="{{route('services.edit', $service)}}" method="get" class="mr-1">
                                @csrf
                                <button type="submit" class="text-blue-700">edit</button>
                            </form>
                        </div>
                        <div>
                            <form action="{{route('services.destroy', $service)}}" method="post" class="mr-1">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="text-red-700">delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>There no services</p>
    @endif
@endsection
