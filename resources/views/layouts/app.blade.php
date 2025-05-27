<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .container { max-width: 1000px; margin: auto; padding: 2rem; background: white; }
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 12px; text-align: left; }
            tr:nth-child(even) { background-color: #c2d9ff; }
            tr:nth-child(odd) { background-color: #c2ffef; }
            button{
                background: #026bff;
                padding: 7px 12px;
                border-radius: 6px;
                font-size: 18px;
                font-weight: 900;
                color: #ffffff;
            }
            .link-btn{
                background: #bf69f6;
                padding: 5px 10px;
                margin: 4px;
                border-radius: 7px;
            }
            .alert {
                padding: 12px 16px;
                margin-bottom: 16px;
                border-radius: 6px;
                font-weight: bold;
            }

            .alert-success {
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .alert-error, .alert-danger {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @include('partials.alerts')
                <div class="container">
                    {{ @$slot }}
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
