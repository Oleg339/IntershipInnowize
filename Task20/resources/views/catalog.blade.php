@extends('layouts.app')

@section('content')
    @if($products->count())
        @foreach($products as $product)
            <form action="{{route('catalog.store', $product)}}" method="post">
                @csrf
                <div class="flex justify-center p-3">
                    <div class="p-6 shadow-xl p-1 w-8/12 bg-white rounded-lg">
                        <div class="mb-4">
                            <p class="font-bold">{{last(explode('\\', get_class($product)))}}</p>
                            <p class="font-bold">Company: {{$product->company}}</p>
                            <p class="mb-2">Product Name: {{$product->name}}</p>
                            <p class="mb-2">Cost: {{$product->cost}} BYN</p>
                            <span class="~text-gray-500 text-sm">Release Date: {{$product->release_date}}</span>
                            <div class="mb-4">
                                <label for="serviceId">
                                    <select name="serviceId" id="serviceId" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">
                                                Service: {{last(explode('\\', get_class($service)))}},
                                                Deadline {{$service->deadline }}, Cost {{$service->cost}} BYN
                                            </option>
                                        @endforeach
                                            <option value="none">
                                                none
                                            </option>
                                    </select>
                                </label>
                            </div>
                            <div>
                                <button type="submit"
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

