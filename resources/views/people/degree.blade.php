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
        <h1 class="text-2xl font-extrabold text-center m-4">Degr&eacute; de parent&eacute;</h1>

        <form action="{{ route('people.degree') }}" method="POST" class="w-1/3 shadow border border-gray-300 justify-self-center p-5 bg-gray-50 rounded-xl mb-6">
            @csrf
            <div class="mb-6">
                <label class="font-bold" for="person_id">ID de la premi&egrave;re personne</label>
                <input class="w-full shadow border border-gray-500 rounded bg-white p-1" type="number" name="person_id" required>
            </div>
            <div class="mb-6">
                <label class="font-bold" for="target_person_id">ID de la personne cible</label>
                <input class="w-full shadow border border-gray-500 rounded bg-white p-1" type="number" name="target_person_id" required>
            </div>
            <div class="flex justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded" type="submit">Calculer le degr&eacute; de parent&eacute;</button>
            </div>
        </form>

        @if(isset($degree))
            @if($degree === false)
                <p class="text-center m-4 text-red-500 font-bold">
                    Aucun lien trouv&eacute; ou le degr&eacute; est trop &eacute;lev&eacute; (sup&eacute;rieur &agrave; 25)
                </p>
            @else
                <p class="text-center m-4 text-green-500 font-bold">
                    Le degr&eacute; de parent&eacute; entre les personnes est de : <span class="text-black">{{ $degree }}</span>
                </p>
                <p class="text-center m-4 text-green-500 font-bold">
                    Le temps d'ex&eacute;cution est de : <span class="text-black">{{ $time }} ms</span>
                </p>
                <p class="text-center m-4 text-green-500 font-bold">
                    Le nombre de requ&ecirc;te est de : <span class="text-black">{{ $nb_queries }}</span>
                </p>
                <p class="text-center m-4 text-green-500 font-bold">
                    Le plus court chemin est :
                    <span class="text-black">
                        @foreach($shortest_path as $elt)
                            {{ $elt }}
                            @if(!$loop->last)
                                ->
                            @endif
                        @endforeach
                    </span>
                </p>
            @endif
        @endif
    </body>
</html>
