@extends('layouts.app')

@section('title', $text->title)

@section('content')
<div class="container">
    <!-- Заголовок и информация о работе -->
    <div class="mb-4">
        <h1>{{ $text->title }}</h1>
        <p class="text-muted">
            <small>Автор: <a href="{{ route('user.profile', $text->user->id) }}">{{ $text->user->name }}</a></small> |
            <small>Жанр: {{ $text->genre->name }}</small> |
            <small>Категория: {{ $text->category->name }}</small> |
            <small>Статус: {{ $text->status }}</small> |
            <small>Последнее обновление: {{ $text->last_updated }}</small>
        </p>
    </div>

    <!-- Предупреждения -->
    @if ($text->warnings)
        <div class="alert alert-warning">
            <strong>Предупреждения:</strong> {{ $text->warnings }}
        </div>
    @endif

    <!-- Описание -->
    <div class="mb-4">
        <h4>Описание</h4>
        <p>{{ $text->description }}</p>
    </div>

    <!-- Основной контент -->
    <div class="mb-4">
        <h4>Содержание</h4>
        <p>{!! nl2br(e($text->content)) !!}</p>
    </div>

    <!-- Интерактивные элементы -->
    <div class="mb-4 d-flex justify-content-between">
        <!-- Рейтинг 
        <div>
            <h5>Рейтинг: {{ number_format($text->statistics, 1) }} / 5</h5>
            @auth
                <form action="{{ route('ratings.store', $text->id) }}" method="POST" class="d-inline">
                    @csrf
                    <select name="rating" class="form-select d-inline w-auto" required>
                        <option value="" disabled selected>Оценить</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Отправить</button>
                </form>
            @endauth
        </div>
        -->
        <!-- Добавить в избранное -->
        @auth
            <form action="{{ route('favorites.toggle', $text->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-{{ $isFavorite ? 'danger' : 'success' }}">
                    {{ $isFavorite ? 'Удалить из избранного' : 'Добавить в избранное' }}
                </button>
            </form>
        @endauth
    </div>

    <!-- Комментарии -->
    <div class="mt-5">
        <h4>Комментарии ({{ $text->statistics}})</h4>
        @auth
            <form action="{{ route('comments.store', $text->id) }}" method="POST" class="mb-4">
                @csrf
                <textarea name="content" class="form-control" rows="3" placeholder="Оставьте комментарий..." required></textarea>
                <button type="submit" class="btn btn-primary mt-2">Отправить</button>
            </form>
        @endauth

        @if ($comments->isEmpty())
            <p class="text-muted">Комментариев пока нет. Будьте первым!</p>
        @else
            @foreach ($comments as $comment)
                <div class="mb-3">
                    <p class="mb-1"><strong>{{ $comment->user->name }}</strong> <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small></p>
                    <p>{{ $comment->content }}</p>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
