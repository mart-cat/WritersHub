@extends('layouts.app')

@section('title', $text->title)

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>{{ $text->title }}</h1>
            <p class="text-muted">
                <small>Автор: <a href="{{ route('user.profile', $text->user->id) }}">{{ $text->user->name }}</a></small> |
                <small>Жанр: {{ $text->genre->name }}</small> |
                <small>
                    @if ($text->categories && $text->categories->count())
                @foreach ($text->categories as $category)
                    {{ $category->name }}{{ !$loop->last ? ',' : '' }}
                @endforeach
                @endif 
                |</small>
                <small>Статус: {{ $text->status }}</small> |
                <small>Последнее обновление: {{ $text->last_updated }}</small>
            </p>
        </div>

        @if ($text->warnings)
            <div class="alert alert-warning">
                <strong>Предупреждения:</strong> {{ $text->warnings }}
            </div>
        @endif

        <div class="mb-4">
            <h4>Описание</h4>
            <p>{{ $text->description }}</p>
        </div>

        <div class="mb-4">
            <h4>Содержание</h4>
            @foreach($text->chapters as $chapter)
                <div id="chapter-title"></div>
                <div id="chapter-content">{!! $text->content !!}</div>
            @endforeach
        </div>
        
        @auth
        @if(auth()->id() === $text->user_id)
                <a href="{{ route('texts.edit', $text->id) }}" class="btn btn-warning">Редактировать</a>
            @endif
        @endauth

        <div>
            <button id="prev-chapter">Предыдущая глава</button>
            <button id="next-chapter">Следующая глава</button>
        </div>



        @auth
            <form action="{{ route('favorites.toggle', $text->id) }}" method="POST" class="mb-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-{{ $isFavorite ? 'danger' : 'success' }}">
                    {{ $isFavorite ? 'Удалить из избранного' : 'Добавить в избранное' }}
                </button>
            </form>
        @endauth

        <div class="mt-5">
            <h4>Комментарии ({{ $comments_count }})</h4>

            @auth
                <form action="{{ route('comments.store', $text->id) }}" method="POST" class="mb-4">
                    @csrf
                    <textarea name="content" class="form-control" rows="3" placeholder="Оставьте комментарий..."
                        required></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Отправить</button>
                </form>
            @endauth

            @if ($comments->isEmpty())
                <p class="text-muted">Комментариев пока нет. Будьте первым!</p>
            @else
                @foreach ($comments as $comment)
                    @include('partials.comment', ['comment' => $comment])
                @endforeach
            @endif
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Обработка кнопки "Ответить" в комментариях
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('reply-btn')) {
                let commentId = event.target.dataset.commentId;
                let userName = event.target.dataset.userName;
                let commentContainer = document.querySelector(`[data-comment-id='${commentId}']`);
                let existingForm = commentContainer.querySelector('.reply-form');

                document.querySelectorAll('.reply-form').forEach(form => form.style.display = 'none');

                if (existingForm) {
                    existingForm.style.display = existingForm.style.display === 'block' ? 'none' : 'block';
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

        // Форматирование текста главы
        function formatContent(content) {
            content = content.replace(/\n/g, '<br>');
            content = content.replace(/\*([^\*]+)\*/g, '<i>$1</i>');
            content = content.replace(/_([^_]+)_/g, '<i>$1</i>');
            content = content.replace(/\*\*([^\*]+)\*\*/g, '<b>$1</b>');
            content = content.replace(/__([^_]+)__/g, '<b>$1</b>');
            return content;
        }

        // Переключение глав
        let currentChapterIndex = 0;
        const chapters = @json($text->chapters);

        function loadChapter(chapterIndex) {
            const chapter = chapters[chapterIndex];

            if (chapter) {
                fetch(`/chapter/${chapter.id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.title && data.content) {
                            document.getElementById('chapter-title').innerHTML = `<h5>${data.title}</h5>`;
                            document.getElementById('chapter-content').innerHTML = formatContent(data.content);

                            // Прокрутка к началу главы
                            document.getElementById('chapter-title').scrollIntoView({ behavior: 'smooth' });
                        } else {
                            console.error('Chapter not found');
                        }
                    })
                    .catch(error => console.error('Error loading chapter:', error));
            }
        }

        document.getElementById('prev-chapter').addEventListener('click', function () {
            if (currentChapterIndex > 0) {
                currentChapterIndex--;
                loadChapter(currentChapterIndex);
            }
        });

        document.getElementById('next-chapter').addEventListener('click', function () {
            if (currentChapterIndex < chapters.length - 1) {
                currentChapterIndex++;
                loadChapter(currentChapterIndex);
            }
        });

        loadChapter(currentChapterIndex);
    });
</script>


    </script>
@endsection