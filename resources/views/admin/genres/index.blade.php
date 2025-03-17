@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Жанры</h1>

    <!-- Форма добавления жанра -->
    <form action="{{ route('admin.genres.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Название жанра" required>
        <button type="submit">Добавить</button>
    </form>

    <!-- Список жанров -->
    <ul>
        @foreach($genres as $genre)
            <li>
                {{ $genre->name }}
                <form action="{{ route('admin.genres.delete', $genre->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
