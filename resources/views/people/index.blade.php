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

        <table class="m-4 w-auto text-left">
            <tr class="uppercase bg-white sticky top-0 border-solid border-1 border-gray-200">
                <th class="w-1/25 p-1">id</th>
                <th class="w-1/6 p-1">created_by</th>
                <th class="w-1/6 p-1">first_name</th>
                <th class="w-1/6 p-1">last_name</th>
                <th class="w-1/6 p-1">birth_name</th>
                <th class="w-1/4 p-1">middle_names</th>
                <th class="w-1/6 p-1">date_of_birth</th>
            </tr>
            @foreach($people as $person)
                <tr class="even:bg-gray-100 odd:bg-white border-solid border-1 border-gray-200">
                    <td class="p-1">{{ $person->id }}</td>
                    <td class="p-1">{{ $person->creator->name }}</td>
                    <td class="p-1">{{ $person->first_name }}</td>
                    <td class="p-1">{{ $person->last_name }}</td>
                    <td class="p-1">{{ $person->birth_name }}</td>
                    <td class="p-1">{{ $person->middle_names }}</td>
                    <td class="p-1">{{ $person->date_of_birth }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>

