@props(['text', 'isFavorite'])
<div class="card mb-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-2xl font-semibold mb-4">
            <a href="{{ route('texts.show', $text->id) }}"
                class="text-orange-600 hover:text-orange-800">{{ $text->title }}</a>
        </h3>
        <p class="text-gray-600 mb-4">{{ $text->description }}</p>
        <div class="text-sm text-gray-500 mb-4">
            <span>Автор: <a href="{{ route('user.profile', $text->user->id) }}"
                    class="text-blue-600 hover:text-blue-800">{{ $text->user->name }}</a></span>
            <span class="ml-4">Жанр: {{ $text->genre->name }}</span>
            <span class="ml-4">Категория: {{ $text->category->name }}</span>
            <span class="ml-4">Статус: {{ $text->status }}</span>
        </div>

        @if ($text->warnings)
            <a href="javascript:void(0);" class="text-blue-500 hover:text-blue-700"
                onclick="toggleSpoiler({{ $text->id }})">Спойлер</a>

            <div class="spoiler-content mt-2" id="spoiler-content-{{ $text->id }}" style="display: none;">
                <span class="text-gray-700">{{ $text->warnings }}</span>
            </div>
        @endif
        <!-- Проверка на авторизацию и отображение кнопки добавления в избранное -->
        @auth
            <!-- Проверяем текущий маршрут и скрываем блок, если не на странице избранного -->
            @if (request()->is('favorites*'))
                <form action="{{ route('favorites.toggle', $text->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        @if ($text->isFavorite)
                            Убрать из избранного
                        @else
                            Добавить в избранное
                        @endif
                    </button>
                </form>
            @endif
        @endauth
    </div>
</div>

<script>
    function toggleSpoiler(textId) {
        var spoilerContent = document.getElementById('spoiler-content-' + textId);
        var spoilerButton = document.querySelector('a[onclick="toggleSpoiler(' + textId + ')"]');

        // Переключаем видимость спойлера
        if (spoilerContent.style.display === 'none') {
            spoilerContent.style.display = 'block'; // показываем спойлер
            spoilerButton.textContent = 'Скрыть предупреждения'; // меняем текст кнопки
        } else {
            spoilerContent.style.display = 'none'; // скрываем спойлер
            spoilerButton.textContent = 'Предупреждения'; // возвращаем текст
        }
    }
</script>