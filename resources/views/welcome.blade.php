<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BPHTB Online') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Dinamic Base & Asset Path for Subdirectory & Artisan Serve -->
    @php
        $isCliServer = php_sapi_name() === 'cli-server';
        $basePath = $isCliServer ? '/' : rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\') . '/';
        $assetPrefix = $isCliServer ? '' : 'public/';
    @endphp
    <base href="{{ $basePath }}">

    <!-- Styles -->
    <link href="{{ $assetPrefix }}css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app"></div>

    <!-- Scripts -->
    <script src="{{ $assetPrefix }}js/app.js"></script>
</body>
</html>
