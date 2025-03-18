<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Alexis Beauvois - Test stage Full-stack O'CD</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @if(session('success'))
            <div class="text-green-500 font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="text-red-500 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="m-4">
            <a href="/people" class="hover:text-blue-500">INDEX</a>
        </div>

        <div class="m-4">
            <a href="/people/show" class="hover:text-blue-500">SHOW</a>
        </div>

        <div class="m-4">
            <a href="/people/create" class="hover:text-blue-500">CREATE</a>
        </div>

        <div class="m-4">
            <a href="/people/degree" class="hover:text-blue-500">DEGREE</a>
        </div>

        @if(!Auth::check())
            <div class="m-4">
                <a href="/login" class="hover:text-blue-500">LOGIN</a>
            </div>
        @endif

        @if(!Auth::check())
            <div class="m-4">
                <a href="/register" class="hover:text-blue-500">REGISTER</a>
            </div>
        @endif

        @if(Auth::check())
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="m-4">
                    <button type="submit" class="hover:text-blue-500">LOGOUT</button>
                </div>
            </form>
        @endif
    </body>
</html>
