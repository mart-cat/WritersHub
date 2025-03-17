@props(['text'])

<div class="text-card">
    <h3><a href="{{ route('texts.show', $text->id) }}">{{ $text->title }}</a></h3>
    <p>{{ $text->description }}</p>
    <span>Автор: <a href="{{ route('user.profile', $text->user->id) }}">{{ $text->user->name }}</a></span>
    <span>Жанр: {{ $text->genre->name }}</span>
    <span>Категория: {{ $text->category->name }}</span>
    <span>Статус: {{ $text->status }}</span>

    <!-- Показываем кнопку "Спойлер" только если предупреждения существуют -->
    @if($text->warnings)
        <a href="javascript:void(0);" class="spoiler-btn" onclick="toggleSpoiler({{ $text->id }})">Спойлер</a>
    @endif

    <!-- Скрытые предупреждения, которые показываются по нажатию -->
    @if($text->warnings)
        <div class="spoiler-content" id="spoiler-content-{{ $text->id }}" style="display: none;">
            <span>{{ $text->warnings }}</span>
        </div>
    @endif
</div>

<!-- Скрипт для управления видимостью спойлера -->
<script>
    function toggleSpoiler(textId) {
        var spoilerContent = document.getElementById('spoiler-content-' + textId);
        var spoilerButton = document.querySelector('a[onclick="toggleSpoiler(' + textId + ')"]');

        // Переключаем видимость только если спойлер еще не открыт
        if (spoilerContent.style.display === 'none') {
            spoilerContent.style.display = 'inline'; // показываем спойлер
            spoilerButton.style.pointerEvents = 'none'; // делаем кнопку неактивной
            spoilerButton.style.color = '#777'; // меняем цвет на серый (для неактивной ссылки)
        }
    }
</script>
