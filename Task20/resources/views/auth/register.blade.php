@extends('layouts.app')

@section('content')
    <div class="flex justify-center p-6">
        <div class="text-center p-6 shadow-lg w-4/12 bg-white rounded-lg">
            <form action="{{route('register')}}"  method="post">
                @csrf
                <div class="mb-4">
                    <label for="name"></label>
                    <input type="text" name="name" id="name" placeholder="Your Name"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{old('name')}}">
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email"></label>
                    <input type="email" name="email" id="email" placeholder="Your Email"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{old('email')}}">
                    @error('email')
                        <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password"></label>
                    <input type="password" name="password" id="password" placeholder="Your password"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="">
                    @error('password')
                    <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation"></label>
                    <input type="password" name="password_confirmation" id="password" placeholder="Confirm password"
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="">
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 px-4 py-3 text-white rounded font-medium w-full"> Submit </button>
                </div>
            </form>
        </div>
    </div>
@endsection
