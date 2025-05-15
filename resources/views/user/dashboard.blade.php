@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Основной контент -->
        <div class="col-md-8">
            <h1>Добро пожаловать, {{ auth()->user()->name }}</h1>

            <!-- Избранное -->
            @if(auth()->user()->favorites->isNotEmpty())
                <div class="section">
                    <h3>Ваши избранные тексты</h3>
                    <ul>
                        @foreach(auth()->user()->favorites as $favorite)
                            <li><a href="{{ route('texts.show', $favorite->id) }}">{{ $favorite->title }}</a></li>
                        @endforeach
                    </ul>
                    <a href="{{ route('user.favorites') }}" class="btn btn-link">Посмотреть все избранные</a>
                </div>
            @else
                <div class="section">
                    <p>У вас нет избранных текстов.
                    </p>
                </div>
            @endif

            <!-- Подписки-->
            @if(auth()->user()->subscriptions)
                <div class="section">
                    <h3>Ваши подписки</h3>
                    <ul>
                        @foreach(auth()->user()->subscriptions as $subscription)
                            <li><a href="{{ route('user.profile', $subscription->author_id) }}">{{ $subscription->author->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="section">
                    <p>Вы еще не подписаны на других пользователей. </p>
                </div>
            @endif

            <!-- Мои тексты -->
            @if(auth()->user()->texts)
                <div class="section">
                    <h3>Мои тексты</h3>
                    <ul>
                        @foreach(auth()->user()->texts as $text)
                        @include('components.textCard', ['text' => $text])
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="section">
                    <p>Вы еще не написали ни одного текста. <a href="{{ route('texts.create') }}">Напишите свой первый
                            текст</a>!</p>
                </div>
            @endif

        </div>

        <!-- Боковая панель с кнопками -->
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item"><a href="{{ route('user.favorites') }}">Избранные тексты</a></li>
                <li class="list-group-item"><a href="{{ route('user.subscriptions') }}">Ваши подписки</a></li>
                <li class="list-group-item"><a href="{{ route('user.profile.edit', auth()->id()) }}">Редактировать
                        профиль</a></li>
                <li class="list-group-item"><a href="{{ route('texts.create') }}">Создать текст</a></li>
            </ul>
        </div>
        @endsection