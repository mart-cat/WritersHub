@extends('layouts.app')

@section('title', $text->title)

@section('content')
    <!-- ОБЁРТКА ДЛЯ ФОНА + ЗАГОЛОВОК -->
    <div class="relative w-full min-h-[60vh] overflow-hidden text-[20px]">
        <!-- Фон -->
        <div class="absolute inset-0 z-0 bg-no-repeat bg-cover bg-center"
            style="background-image: url('/images/Backround-base.png')"></div>

        <!-- Контент на фоне -->
        <div class="relative z-10 flex flex-col px-4 pt-[150px] pb-20 max-w-5xl mx-auto ">
            <h2 class="text-5xl mb-6">{{ $text->title }}</h2>


            <!-- Автор -->
            <div class="flex items-center gap-2 text-sm mb-4">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-6 8a6 6 0 0112 0H4z" />
                </svg>
                <a href="{{ route('user.profile', $text->user->id) }}" class="underline hover:no-underline">
                    {{ $text->user->name }}
                </a>

            </div>

            <!-- Метки -->
            <div class="flex flex-wrap items-center gap-2">
                @include('components.tags', ['text' => $text])
                @if ($text->age_rating && $text->age_rating !== '0+')
                    <p><span class="text-sm px-2 py-1 rounded bg-orange-700 text-white">{{ $text->age_rating }}</span></p>
                @endif
            </div>
            <!-- Описание -->
            <div class="mb-6">
                <h3 class=" mb-1">Описание</h3>
                <p>{{ $text->description }}</p>
            </div>

            <!-- Посвящение -->
            @if ($text->dedication)
                <div class="mb-6">
                    <h3 class=" mb-1">Посвящается</h3>
                    <p>{{ $text->dedication }}</p>
                </div>
            @endif

            <!-- Категории -->
            @if ($text->categories && $text->categories->count())
                <div class="mb-6">
                    <h3 class=" mb-1">Категории</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($text->categories as $category)
                            <span class="bg-[#BD7835] text-white text-sm px-2 py-1 rounded">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Предупреждения -->
            @if ($text->warnings)
                <div class="mb-6">
                    <h3 class=" mb-1 text-red-800 underline">Предупреждения</h3>
                    <p>{{ $text->warnings }}</p>
                </div>
            @endif

        </div>
    </div>
    </div>

    <!-- Содержание -->

    <div class="mb-8 text-[20px]">
        <h3 class="mb-1 text-center">Содержание</h3>

        @if ($text->chapters->count() === 0)
            <p class="mb-8 leading-relaxed">Автор не добавил глав.</p>
        @else
            <h3 id="chapter-title" class="text-xl mb-4"></h3>
            <p id="chapter-content" class="mb-8 leading-relaxed"></p>
        @endif
    </div>

    @if ($text->chapters->count() > 0)

        @if ($text->chapters->count() > 1)
            <div class="flex justify-center gap-6 mb-12">
                <button id="prev-chapter" class="px-6 py-3 bg-orange-700 text-white rounded-lg hover:bg-orange-800 transition">
                    ← Предыдущая глава
                </button>

                <button id="next-chapter" class="px-6 py-3 bg-orange-700 text-white rounded-lg hover:bg-orange-800 transition">
                    Следующая глава →
                </button>
            </div>
        @endif

        {{-- Избранное (для любого количества глав) --}}
        @auth
            <form action="{{ route('favorites.toggle', $text->id) }}" method="POST" class="mb-8 text-center">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 rounded {{ $isFavorite ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white">
                    {{ $isFavorite ? 'Удалить из избранного' : 'Добавить в избранное' }}
                </button>
            </form>
        @endauth
    @endif

    <!-- Кнопка редактировать -->
    @auth
        @if(auth()->id() === $text->user_id)
            <a href="{{ route('texts.edit', $text->id) }}"
                class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 mb-6">
                Редактировать
            </a>
        @endif
    @endauth



    <!-- Комментарии -->
    <div class="mt-5">
        <h3 class=" mb-4 text-[20px]">Комментарии ({{ $comments_count }})</h3>

        @auth
            <form action="{{ route('comments.store', $text->id) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="content" rows="3" required
                    class="w-full p-2 border border-yellow-700 rounded bg-white"></textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-orange-700 text-white rounded hover:bg-orange-800">
                    Отправить
                </button>
            </form>
        @endauth

        @if ($comments->isEmpty())
            <p>Комментариев пока нет. Будьте первым!</p>
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
                                document.getElementById('chapter-title').innerHTML = `<h3>${data.title}</h3>`;
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

            const prevBtn = document.getElementById('prev-chapter');
            const nextBtn = document.getElementById('next-chapter');

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    if (currentChapterIndex > 0) {
                        currentChapterIndex--;
                        loadChapter(currentChapterIndex);
                    }
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    if (currentChapterIndex < chapters.length - 1) {
                        currentChapterIndex++;
                        loadChapter(currentChapterIndex);
                    }
                });
            }


            loadChapter(currentChapterIndex);
        });
    </script>


    </script>
@endsection