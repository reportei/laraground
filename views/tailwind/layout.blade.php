<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="w-full h-full overflow-hidden">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        <title>Laraground</title>

        <!-- Styles -->
        @livewireStyles
        <link href="{{ asset('vendor/laraground/tailwind.css') }}?_v={{env('APP_VERSION', '1.0.0')}}" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @stack('styles')

    @if (app()->environment('production'))
        <!-- Google Tag Manager -->
        <!-- End Google Tag Manager -->
        @else
            <style>
                .phpdebugbar-closed {
                    left: auto !important;
                    right: 0 !important;
                }
            </style>
            <!-- Google Tag Manager -->
            <!-- End Google Tag Manager -->
        @endif
    </head>
    <body class="{{ (isset($class) ? $class : '') }}">
        @if (app()->environment('production'))
            <!-- Google Tag Manager (noscript) -->
            <!-- End Google Tag Manager (noscript) -->
        @else
            <!-- Google Tag Manager (noscript) -->
            <!-- End Google Tag Manager (noscript) -->
        @endif

        @yield('body')

        <!-- Scripts -->
        @livewireScripts
        <script src="{{ asset('vendor/laraground/fontawesome.js') }}"></script>
        <script src="{{ asset('vendor/laraground/tailwind.js') }}?_v={{env('APP_VERSION', '1.0.0')}}" defer></script>
        @stack('scripts')
    </body>
</html>
