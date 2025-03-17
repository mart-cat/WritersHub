@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
<div class="container">
    
    <!-- Приветственное сообщение -->
    <div class="first_screen text-center py-5">
        <div class="slogan">
            <h1>Добро пожаловать на WritersHub!</h1>
            <h5>Платформа для начинающих писателей, где вы можете создавать, делиться и читать произведения.</h5>
            <a href="{{ route('texts.index') }}" class="btn btn-primary">Посмотреть все тексты</a>
        </div>
    </div>

    <!-- Фильтры (по жанрам/категориям) -->
    <div class="form_cont">
        <h2>Найдите интересующий вас текст</h2>
        <form action="{{ route('texts.index') }}" method="GET">
            <div class="form-group">
                <select name="genre">
                    <option value="">Выберите жанр</option>
                    @foreach(App\Models\Genre::all() as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="category">
                    <option value="">Выберите категорию</option>
                    @foreach(App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Найти</button>
        </form>
    </div>

    <!-- Секция популярных текстов -->
    <div class="mb-4">
        <h2>Популярные тексты</h2>
        <div class="row">
            @foreach($texts as $text)
                <div class="col-md-4">
                    <div class="card">
                        <h5>{{ $text->short_title }}</h5>
                        <p>{{ $text->short_description }}</p>
                        <p class="text-muted">
                            <small>Автор: <a href="{{ route('user.profile', $text->user->id) }}">{{ $text->user->name }}</a></small><br>
                            <small>Жанр: {{ $text->genre->name }}</small>
                        </p>
                        <a href="{{ route('texts.show', $text->id) }}" class="btn btn-outline">Читать</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Кнопка для авторов -->
    @auth
        <div class="text-center my-4">
            <a href="{{ route('texts.create') }}" class="btn btn-primary">Создать новый текст</a>
        </div>
    @endauth
</div>
@endsection
