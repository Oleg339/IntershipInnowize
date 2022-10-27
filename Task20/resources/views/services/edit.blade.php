@extends('layouts.app')
@section('content')
    <div class="flex justify-center p-6">
        <div class="shadow-xl text-center p-6 w-8/12 bg-white rounded-lg">
            <form action="{{route('services.update', $service)}}" method="post">
                @method('PUT')
                @csrf
                <div class="mb-4">
                    <label for="cost"></label>
                    <input type="number" name="cost" id="cost" placeholder="Cost"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('cost') border-red-500 @enderror"
                           value="{{$service->cost}}">
                    @error('cost')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="deadline"></label>
                    <input type="date" name="deadline" id="deadline" placeholder="DeadLine"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('deadline') border-red-500 @enderror"
                           value="{{$service->deadline}}">
                    @error('deadline')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="type">
                        <select name="type" id="type" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                            @foreach ($types as $type)
                                <option value="{{ $type }}" @selected(last(explode('\\', get_class($service))) == $type)>
                                    {{ $type }}
                                </option>
                            @endforeach
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
@endsection
