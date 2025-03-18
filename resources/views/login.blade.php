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
        <h1 class="text-2xl font-extrabold text-center m-4">Connexion</h1>

        @if(session('success'))
            <div class="text-green-500 text-center font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="text-red-500 text-center font-bold">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="w-1/3 shadow border border-gray-300 justify-self-center p-5 bg-gray-50 rounded-xl">
            @csrf
            <div class="mb-6">
                <label class="font-bold" for="email">Email</label>
                <input class="w-full shadow border border-gray-500 rounded bg-white p-1"  type="email" name="email" id="email" required>
            </div>
            <div class="mb-6">
                <label class="font-bold" for="password">Mot de passe</label>
                <input class="w-full shadow border border-gray-500 rounded bg-white p-1"  type="password" name="password" id="password" required>
            </div>
            <div class="flex justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded" type="submit">Se connecter</button>
            </div>
        </form>
    </body>
</html>
