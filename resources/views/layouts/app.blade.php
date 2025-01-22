<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Сайт для писателей')</title>
</head>
<body>
    {{-- Навигация --}}
    @include('partials.navbar')

    {{-- Сообщения об ошибках или успехах --}}
    @include('partials.alerts')

    {{-- Основной контент --}}
    <main>
        @yield('content')
    </main>

    {{-- Футер --}}
    @include('partials.footer')
</body>
</html>
