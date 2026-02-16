<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-500">

@include('layouts.navigation')

<main class="max-w-7xl mx-auto py-6">
    @yield('content')
</main>

</body>
</html>