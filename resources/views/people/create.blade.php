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
    <h1 class="text-2xl font-extrabold text-center m-4">Cr&eacute;er une personne</h1>

    <form action="{{ route('people.store') }}" method="POST" class="w-1/3 shadow border border-gray-300 justify-self-center p-5 bg-gray-50 rounded-xl">
        @csrf
        <div class="mb-6">
            <label class="font-bold" for="first_name">Pr&eacute;nom</label>
            <br/>
            <input class="w-full shadow border border-gray-500 rounded bg-white p-1" type="text" name="first_name" id="first_name" required>
        </div>
        <div class="mb-6">
            <label class="font-bold" for="last_name">Nom</label>
            <br/>
            <input class="w-full shadow border border-gray-500 rounded bg-white p-1" type="text" name="last_name" id="last_name" required>
        </div>
        <div class="mb-6">
            <label class="font-bold" for="birth_name">Nom de naissance</label>
            <br/>
            <input class="w-full shadow border border-gray-500 rounded bg-white p-1" type="text" name="birth_name" id="birth_name">
        </div>
        <div class="mb-6">
            <label class="font-bold" for="middle_names">Autres pr&eacute;noms</label>
            <br/>
            <input class="w-full shadow border border-gray-500 rounded bg-white p-1" type="text" name="middle_names" id="middle_names">
        </div>
        <div class="mb-6">
            <label class="font-bold" for="birth_date">Date de naissance</label>
            <br/>
            <input class="shadow border border-gray-500 rounded bg-white p-1" type="date" name="date_of_birth" id="birth_date">
        </div>
        <div class="flex justify-center">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded" type="submit">Cr&eacute;er</button>
        </div>
    </form>
</body>
