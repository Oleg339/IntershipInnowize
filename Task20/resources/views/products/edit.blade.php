@extends('layouts.app')
@section('content')
    <div class="flex justify-center p-6">
        <div class="shadow-xl text-center p-6 w-8/12 bg-white rounded-lg">
            <form action="{{route('products.update', $product)}}" method="post">
                @method('PUT')
                @csrf
                <div class="mb-4">
                    <label for="name"></label>
                    <input type="text" name="name" id="name" placeholder="Product Name"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror"
                    value="{{$product->name}}">
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="company"></label>
                    <input type="text" name="company" id="company" placeholder="Company Name"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('company') border-red-500 @enderror"
                    value="{{$product->company}}">
                    @error('company')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="cost"></label>
                    <input type="number" name="cost" id="cost" placeholder="Cost"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('cost') border-red-500 @enderror "
                    value="{{$product->cost}}">
                    @error('cost')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="release_date"></label>
                    <input type="date" name="release_date" id="release_date" placeholder="Release Date"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('release_date') border-red-500 @enderror"
                    value="{{$product->release_date}}">
                    @error('release_date')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 px-4 py-3 text-white rounded font-medium w-full"> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
