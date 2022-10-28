<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Document</title>
</head>
<body class="bg-gray-300">
<nav class="p-3 shadow-xl bg-gray-100 flex items-center justify-between ml-auto">
    <ul class="flex items-center">
        <li>
            <a href="{{route('catalog')}}" class="p-3">Home</a>
        </li>
        <li>
            <a href="{{route('products')}}" class="p-3">Products</a>
        </li>
        <li>
            <a href="{{route('services')}}" class="p-3">Services</a>
        </li>
    </ul>
</nav>
@yield('content')
</body>
</html>
