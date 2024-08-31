<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="burning">
    <x-base-head />

    <body class="min-h-screen font-sans antialiased">
        {{ $slot }}
    </body>
</html>
