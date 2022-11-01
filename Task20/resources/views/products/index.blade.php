@extends('layouts.app')
@section('content')
    <div class="flex justify-center p-6">
        <div class="shadow-xl text-center p-6 w-8/12 bg-white rounded-lg">
            <form action="{{route('products')}}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="name"></label>
                    <input type="text" name="name" id="name" placeholder="Product Name"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 "
                           value="{{old('name')}}@enderror">
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="company"></label>
                    <input type="text" name="company" id="company" placeholder="Company Name"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('company') border-red-500"
                           value="{{old('company')}}@enderror">
                    @error('company')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
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
                    <label for="release_date"></label>
                    <input type="date" name="release_date" id="release_date" placeholder="Release Date"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('release_date') border-red-500"
                           value="{{old('release_date')}} @enderror">
                    @error('release_date')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="type">
                        <select name="type" id="type" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                            <option value="Fridge">
                                Fridge
                            </option>
                            <option value="Phone">
                                Phone
                            </option>
                            <option value="TV">
                                TV
                            </option>
                            <option value="Laptop">
                                Laptop
                            </option>
                        </select>
                    </label>
                </div>
                <div>
                    <button type="submit" name="submit" class="bg-blue-500 px-4 py-3 text-white rounded font-medium w-full"> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
        <form action="{{route('products')}}" method="get">
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
    @if($products->count())
        @foreach($products as $product)
            <div class="flex justify-center p-3">
                <div class="p-6 shadow-xl p-1 w-8/12 bg-white rounded-lg">
                    <div class="mb-4">
                        <p class="font-bold">{{$product->type}}</p>
                        <p class="font-bold">Company: {{$product->company}}</p>
                        <p class="mb-2">Product Name: {{$product->name}}</p>
                        <p class="mb-2">Cost: {{$product->cost}} BYN</p>
                        <span class="~text-gray-500 text-sm">Release Date: {{$product->release_date}}</span>
                        <div>
                            <form action="{{route('products.edit', $product->id)}}" method="get" class="mr-1">
                                @csrf
                                <button type="submit" class="text-blue-700">edit</button>
                            </form>
                        </div>
                        <div>
                            <form action="{{route('products.destroy', $product)}}" method="post" class="mr-1">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="text-red-700">delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="text-center">
            {{$products->links('pagination::tailwind')}}
        </div>

    @else
        <p>There no products</p>
    @endif
@endsection
