@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
<div class="container">
    <!-- Приветственное сообщение -->
    <div class="jumbotron text-center my-4">
        <h1>Добро пожаловать на WritersHub!</h1>
        <p class="lead">Платформа для начинающих писателей, где вы можете создавать, делиться и читать произведения.</p>
        <a href="{{ route('texts.index') }}" class="btn btn-primary btn-lg">Посмотреть все тексты</a>
    </div>

    <!-- Секция популярных текстов -->
    <div class="mb-4">
        <h2>Популярные тексты</h2>
        <div class="row">
            @foreach($texts as $text)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $text->short_title }}</h5>
                            <p class="card-text">{{ $text->short_description }}</p>
                            <p class="text-muted">
                                <small>Автор: <a href="{{ route('user.profile', $text->user->id) }}">{{ $text->user->name }}</a></small><br>
                                <small>Жанр: {{ $text->genre->name }}</small>
                            </p>
                            <a href="{{ route('texts.show', $text->id) }}" class="btn btn-primary btn-sm">Читать</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Фильтры (по жанрам/категориям) -->
    <div class="mb-4">
        <h2>Найдите интересующий вас текст</h2>
        <form action="{{ route('texts.index') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <select name="genre" class="form-select">
                        <option value="">Выберите жанр</option>
                        @foreach(App\Models\Genre::all() as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select">
                        <option value="">Выберите категорию</option>
                        @foreach(App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Найти</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Кнопка для авторов -->
    @auth
        <div class="text-center my-4">
            <a href="{{ route('texts.create') }}" class="btn btn-success btn-lg">Создать новый текст</a>
        </div>
    @endauth
</div>
@endsection
