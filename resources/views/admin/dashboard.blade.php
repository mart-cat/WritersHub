@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Админ-панель</h1>
        <p>Вы зашли как администратор.</p>
        <ul>
            <li><a href="{{ route('admin.users') }}">Управление пользователями</a></li>
            <li><a href="{{ route('admin.dashboard') }}">Управление текстами Временно не работает</a></li>
            <li><a href="{{ route('admin.categories') }}">Управление категориями</a></li>
            <li><a href="{{ route('admin.genres') }}">Управление жанрами</a></li>
        </ul>
    </div>
@endsection
