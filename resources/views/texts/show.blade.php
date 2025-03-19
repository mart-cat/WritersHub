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
            <h4>Комментарии ({{ $comments->count() }})</h4>

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
                    <div class="mb-3 comment-container" data-comment-id="{{ $comment->id }}">
                        <p class="mb-1">
                            <strong>
                                <a href="{{ route('user.profile', $comment->user->id) }}">{{ $comment->user->name }}</a>
                            </strong>
                            <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                        </p>
                        <p>{{ $comment->content }}</p>

                        @auth
                            <a href="javascript:void(0);" class="reply-btn text-primary" data-comment-id="{{ $comment->id }}" data-user-name="{{ $comment->user->name }}">Ответить</a>
                        @endauth

                        <!-- Ответы на комментарий -->
                        @foreach ($comment->replies as $reply)
                            <div class="ms-4 mt-2 comment-container comment-reply" data-comment-id="{{ $reply->id }}">
                                <p class="mb-1">
                                    <strong>
                                        <a href="{{ route('user.profile', $reply->user->id) }}">{{ $reply->user->name }}</a>
                                    </strong>
                                    <small class="text-muted">{{ $reply->created_at->format('d.m.Y H:i') }}</small>
                                </p>
                                <p><span class="text-muted">{{ $reply->parent->user->name }}</span>, {{ $reply->content }}</p>

                                @auth
                                    <a href="javascript:void(0);" class="reply-btn text-primary" data-comment-id="{{ $reply->id }}" data-user-name="{{ $reply->user->name }}">Ответить</a>
                                @endauth

                                <!-- Рекурсивное отображение ответов на ответы -->
                                @foreach ($reply->replies as $replyReply)
                                    <div class="ms-4 mt-2 comment-container comment-reply-more" data-comment-id="{{ $replyReply->id }}">
                                        <p class="mb-1">
                                            <strong>
                                                <a href="{{ route('user.profile', $replyReply->user->id) }}">{{ $replyReply->user->name }}</a>
                                            </strong>
                                            <small class="text-muted">{{ $replyReply->created_at->format('d.m.Y H:i') }}</small>
                                        </p>
                                        <p><span class="text-muted">{{ $replyReply->parent->user->name }}</span>, {{ $replyReply->content }}</p>

                                        @auth
                                            <a href="javascript:void(0);" class="reply-btn text-primary" data-comment-id="{{ $replyReply->id }}" data-user-name="{{ $replyReply->user->name }}">Ответить</a>
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('reply-btn')) {
            let commentId = event.target.getAttribute('data-comment-id');
            let userName = event.target.getAttribute('data-user-name');

            let commentContainer = document.querySelector(`[data-comment-id='${commentId}']`);
            let existingForm = commentContainer.querySelector('.reply-form');

            // Закрытие формы, если она уже открыта
            if (existingForm && existingForm.style.display === 'block') {
                existingForm.style.display = 'none';
                return;
            }

            // Закрытие всех других форм
            document.querySelectorAll('.reply-form').forEach(form => {
                form.style.display = 'none';
            });

            // Открытие текущей формы
            if (existingForm) {
                existingForm.style.display = 'block';
            } else {
                let formHtml = `
                    <form action="{{ route('comments.store', $text->id) }}" method="POST" class="reply-form mt-2">
                        @csrf
                        <input type="hidden" name="parent_id" value="${commentId}">
                        <textarea name="content" class="form-control" rows="2" placeholder="Ответить пользователю ${userName}..." required></textarea>
                        <button type="submit" class="btn btn-secondary mt-2">Отправить</button>
                    </form>
                `;
                commentContainer.insertAdjacentHTML('beforeend', formHtml);
            }
        }
    });
});

    </script>
@endsection
