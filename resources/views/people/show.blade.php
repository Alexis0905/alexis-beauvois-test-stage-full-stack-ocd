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
        <form action="{{ route('people.show') }}" method="POST" class="w-1/3 shadow border border-gray-300 justify-self-center p-5 bg-gray-50 rounded-xl m-6">
            @csrf
            <div class="mb-6">
                <label class="font-bold" for="person_id">ID de la personne</label>
                <input class="w-full shadow border border-gray-500 rounded bg-white p-1" type="number" name="person_id" required>
            </div>
            <div class="flex justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded" type="submit">Afficher</button>
            </div>
        </form>

        @if(isset($person))
            <table class="m-4 w-8/10 text-left">
                <tr class="uppercase bg-white border border-gray-200">
                    <th class="w-1/25 p-1">id</th>
                    <th class="w-1/6 p-1">first_name</th>
                    <th class="w-1/6 p-1">last_name</th>
                    <th class="w-1/6 p-1">birth_name</th>
                    <th class="w-1/4 p-1">middle_names</th>
                    <th class="w-1/6 p-1">date_of_birth</th>
                </tr>
                <tr class="even:bg-gray-100 odd:bg-white border border-gray-200">
                    <td class="p-1">{{ $person->id }}</td>
                    <td class="p-1">{{ $person->first_name }}</td>
                    <td class="p-1">{{ $person->last_name }}</td>
                    <td class="p-1">{{ $person->birth_name }}</td>
                    <td class="p-1">{{ $person->middle_names }}</td>
                    <td class="p-1">{{ $person->date_of_birth }}</td>
                </tr>
            </table>
        @endif

        @if(isset($children) && !$children->isEmpty())
            <br/>
            <table class="m-4 w-8/10 text-left">
                <caption class="text-left font-bold text-xl">SES ENFANTS</caption>
                <tr class="uppercase bg-white border border-gray-200">
                    <th class="w-1/25 p-1">id</th>
                    <th class="w-1/6 p-1">first_name</th>
                    <th class="w-1/6 p-1">last_name</th>
                    <th class="w-1/6 p-1">birth_name</th>
                    <th class="w-1/4 p-1">middle_names</th>
                    <th class="w-1/6 p-1">date_of_birth</th>
                </tr>
                @foreach($children as $child)
                    <tr class="even:bg-gray-100 odd:bg-white border border-gray-200">
                        <td class="p-1">{{ $child->id }}</td>
                        <td class="p-1">{{ $child->first_name }}</td>
                        <td class="p-1">{{ $child->last_name }}</td>
                        <td class="p-1">{{ $child->birth_name }}</td>
                        <td class="p-1">{{ $child->middle_names }}</td>
                        <td class="p-1">{{ $child->date_of_birth }}</td>
                    </tr>
                @endforeach
            </table>
        @endif

        @if(isset($parents) && !$parents->isEmpty())
            <table class="m-4 w-8/10 text-left">
                <br/>
                <caption class="text-left font-bold text-xl">SES PARENTS</caption>
                <tr class="uppercase bg-white border-solid border-1 border-gray-200">
                    <th class="w-1/25 p-1">id</th>
                    <th class="w-1/6 p-1">first_name</th>
                    <th class="w-1/6 p-1">last_name</th>
                    <th class="w-1/6 p-1">birth_name</th>
                    <th class="w-1/4 p-1">middle_names</th>
                    <th class="w-1/6 p-1">date_of_birth</th>
                </tr>
                @foreach($parents as $parent)
                    <tr class="even:bg-gray-100 odd:bg-white border-solid border-1 border-gray-200">
                        <td class="p-1">{{ $parent->id }}</td>
                        <td class="p-1">{{ $parent->first_name }}</td>
                        <td class="p-1">{{ $parent->last_name }}</td>
                        <td class="p-1">{{ $parent->birth_name }}</td>
                        <td class="p-1">{{ $parent->middle_names }}</td>
                        <td class="p-1">{{ $parent->date_of_birth }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
    </body>
</html>

