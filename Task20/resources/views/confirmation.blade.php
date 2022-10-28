@extends('layouts.app')

@section('content')
    <div class="flex justify-center p-3">
        <div class="p-6 shadow-xl p-1 w-8/12 bg-white rounded-lg">
            <div class="mb-4">
                <p class="font-bold text-center">Your Order</p>
                <p class="font-bold">Product: {{$order->getProduct()->name}}</p>
                <p>Company: {{$order->getProduct()->company}}</p>
                <p>Cost: {{$order->getProduct()->cost}}</p>
                <p>Release Date: {{$order->getProduct()->release_date}}</p>
                <br>
                @if($order->getService() !== null)
                    <p class="font-bold">{{last(explode('\\', get_class($order->getService())))}}</p>
                    <p>DeadLine: {{$order->getService()->deadline}}</p>
                    <p>Cost: {{$order->getService()->cost}} BYN</p>
                    <p class="font-bold text-center">Cost: {{$order->getCost()}} BYN</p>
                @endif
                <div>
                    <form action="" method="post" class="mr-1 p-4">
                        <div>
                            <button type="submit" class="bg-blue-500 px-4 py-3 text-white rounded font-medium w-full">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
