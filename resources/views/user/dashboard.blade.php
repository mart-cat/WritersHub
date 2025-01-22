@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="container">
    <h1>Добро пожаловать, {{ auth()->user()->name }}</h1>
    <ul>
        <li><a href="{{ route('user.favorites') }}">Избранные тексты</a></li>
        <li><a href="{{ route('user.subscriptions') }}">Ваши подписки</a></li>
        <li><a href="{{ route('user.profile', auth()->id()) }}">Редактировать профиль</a></li>
        <li><a href="{{ route('texts.create') }}">Создать текст</a></li>
    </ul>
</div>
@endsection
