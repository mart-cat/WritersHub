<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админка')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/admin.js') }}" defer></script>
</head>
<body>
    <nav class="admin-navbar">
        <a href="{{ route('admin.dashboard') }}">Главная</a>
        <a href="{{ route('admin.texts') }}">Управление текстами</a>
        <a href="{{ route('admin.users') }}">Управление пользователями</a>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
