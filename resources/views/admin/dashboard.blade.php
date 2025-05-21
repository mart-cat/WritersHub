@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 mt-20 py-12">

            <h1 class="text-4xl  mb-6">Админ-панель</h1>

    <p class=" mb-8">Вы вошли как <strong>администратор</strong>. Выберите раздел для управления:</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('admin.users') }}"
           class="block   hover:bg-yellow-100   rounded-xl p-5 transition">
            <h2 class="text-lg  ">Пользователи</h2>
            <p class="text-sm text-gray-600">Блокировка, поиск, просмотр профилей</p>
        </a>

        <a href="{{ route('admin.texts') }}"
           class="block   hover:bg-yellow-100   rounded-xl p-5 transition">
            <h2 class="text-lg  ">Тексты</h2>
            <p class="text-sm text-gray-600">Фильтрация, блокировка, просмотр</p>
        </a>

        <a href="{{ route('admin.categories') }}"
           class="block   hover:bg-yellow-100   rounded-xl p-5 transition">
            <h2 class="text-lg  ">Категории</h2>
            <p class="text-sm text-gray-600">Создание и редактирование</p>
        </a>

        <a href="{{ route('admin.genres') }}"
           class="block   hover:bg-yellow-100   rounded-xl p-5 transition">
            <h2 class="text-lg  ">Жанры</h2>
            <p class="text-sm text-gray-600">Список и управление</p>
        </a>
    </div>
</div>
@endsection
