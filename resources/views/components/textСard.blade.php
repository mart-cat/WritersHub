<div class="text-card">
    <h3><a href="{{ route('texts.show', $text->id) }}">{{ $text->title }}</a></h3>
    <p>{{ $text->description }}</p>
    <span>Автор: <a href="{{ route('user.profile', $text->user->id) }}">{{ $text->user->name }}</a></span>
    <span>Жанр: {{ $text->genre->name }}</span>
    <span>Категория: {{ $text->category->name }}</span>
    <span>Статус: {{ $text->status }}</span>
</div>
