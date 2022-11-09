@extends('layouts.app')

@section('content')
    <form action="{{route('catalog')}}" method="get">
        <div class="flex justify-center p-3">
            <div class="shadow-xl p-6 w-8/12 bg-white rounded-lg">
                <label for="order">
                    Order By:
                    <select name="order" id="order" class="bg-gray-100 border-2 p-3 rounded-lg">
                        <option value="release_date">
                            Release Date
                        </option>
                        <option value="name">
                            Name
                        </option>
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
                        <option value="Laptop">
                            Laptop
                        </option>
                        <option value="Phone">
                            Phone
                        </option>
                        <option value="Fridge">
                            Fridge
                        </option>
                        <option value="TV">
                            TV
                        </option>
                        <option selected="selected" value="All">
                            All
                        </option>
                    </select>
                </label>
                <button type="submit" class="bg-blue-500 px-4 py-3 text-white rounded font-medium"> Submit
                </button>
            </div>
        </div>
    </form>
    @if($products->count())
        @foreach($products as $product)
            <form action="{{route('catalog.store')}}" method="post">
                @csrf
                <div class="flex justify-center p-3">
                    <div class="p-6 shadow-xl p-1 w-8/12 bg-white rounded-lg">
                        <div class="mb-4">
                            <p class="font-bold">{{last(explode('\\', get_class($product)))}}</p>
                            <p class="font-bold">Company: {{$product->company}}</p>
                            <p class="mb-2">Product Name: {{$product->name}}</p>
                            <p class="mb-2">Cost: {{$product->cost}} BYN | {{round($product->cost / $usdRate, 2)}} USD</p>
                            <span class="~text-gray-500 text-sm">Release Date: {{$product->release_date}}</span>
                            <div class="mb-4">
                                <label for="serviceId">
                                    <select name="serviceId" id="serviceId" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">
                                                Service: {{last(explode('\\', get_class($service)))}},
                                                Deadline {{$service->deadline }}, Cost {{$service->cost}} BYN | {{round($service->cost / $usdRate, 2)}} USD
                                            </option>
                                        @endforeach
                                            <option value="none">
                                                none
                                            </option>
                                    </select>
                                </label>
                            </div>
                            <div>
                                <button type="submit" name="productId" value="{{$product->id}}"
                                        class="bg-blue-500 px-4 py-3 text-white rounded font-medium w-full"> Buy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
    @else
        <p>There no products</p>
    @endif
@endsection

