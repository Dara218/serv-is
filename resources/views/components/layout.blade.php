<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')

        <title>Serv &#9679; is</title>

    </head>

    <body>
        {{ $slot }}

        <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    </body>
</html>
