<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo')</title>
    @vite(['resources/sass/app.scss'])
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    @yield('archivosJS')
</head>

<body class="d-flex flex-column">
    @include('layouts.partials.header')

    <main class="container">

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                Hubo errores al mandar el mensaje:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @yield('contenido')
    </main>

    @include('layouts.partials.footer')
</body>
