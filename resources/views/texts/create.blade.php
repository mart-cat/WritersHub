@extends('layouts.app')

@section('title', 'Создание нового текста')

@section('content')
<div class="container">
    <h1 class="mb-4">Создание нового текста</h1>

    <div class="card">
        <form action="{{ route('texts.store') }}" method="POST">
            @csrf

            <!-- Название -->
            <div class="form-group">
                <label for="title">Название</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Описание -->
            <div class="form-group">
                <label for="description">Краткое описание</label>
                <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Контент -->
            <div class="form-group">
                <label for="content">Полный текст</label>
                <textarea id="content" name="content" rows="8" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Жанр -->
            <div class="form-group">
                <label for="genre_id">Жанр</label>
                <select id="genre_id" name="genre_id" class="form-control @error('genre_id') is-invalid @enderror" required>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
                @error('genre_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Категория -->
            <div class="form-group">
                <label for="category_id">Категория</label>
                <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Теги -->
            <div class="form-group">
                <label for="tags">Теги (через запятую)</label>
                <input type="text" id="tags" name="tags" class="form-control @error('tags') is-invalid @enderror" value="{{ old('tags') }}">
                @error('tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Статус -->
            <div class="form-group">
                <label for="status">Статус</label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="in progress" {{ old('status') == 'in progress' ? 'selected' : '' }}>В процессе</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Завершено</option>
                    <option value="frozen" {{ old('status') == 'frozen' ? 'selected' : '' }}>Заморожено</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Размер -->
            <div class="form-group">
                <label for="size">Размер</label>
                <select id="size" name="size" class="form-control @error('size') is-invalid @enderror" required>
                    <option value="mini" {{ old('size') == 'mini' ? 'selected' : '' }}>Мини</option>
                    <option value="standard" {{ old('size') == 'standard' ? 'selected' : '' }}>Стандарт</option>
                    <option value="maxi" {{ old('size') == 'maxi' ? 'selected' : '' }}>Макси</option>
                </select>
                @error('size')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Количество символов -->
            <div class="form-group">
                <label for="char_count">Количество символов</label>
                <input type="number" id="char_count" name="char_count" class="form-control @error('char_count') is-invalid @enderror" required value="{{ old('char_count') }}">
                @error('char_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Количество глав -->
            <div class="form-group">
                <label for="chapter_count">Количество глав</label>
                <input type="number" id="chapter_count" name="chapter_count" class="form-control @error('chapter_count') is-invalid @enderror" required value="{{ old('chapter_count') }}">
                @error('chapter_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Предупреждения -->
            <div class="form-group">
                <label for="warnings">Предупреждения</label>
                <textarea id="warnings" name="warnings" rows="4" class="form-control @error('warnings') is-invalid @enderror">{{ old('warnings') }}</textarea>
                @error('warnings')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Возрастной рейтинг -->
            <div class="form-group">
                <label for="age_rating">Возрастной рейтинг</label>
                <input type="text" id="age_rating" name="age_rating" class="form-control @error('age_rating') is-invalid @enderror" value="{{ old('age_rating', '0+') }}">
                @error('age_rating')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Посвящение -->
            <div class="form-group">
                <label for="dedication">Посвящение</label>
                <input type="text" id="dedication" name="dedication" class="form-control @error('dedication') is-invalid @enderror" value="{{ old('dedication') }}">
                @error('dedication')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Разрешение на публикацию -->
            <div class="form-group">
                <label for="publication_permission">Разрешение на публикацию</label>
                <select id="publication_permission" name="publication_permission" class="form-control @error('publication_permission') is-invalid @enderror" required>
                    <option value="author_only" {{ old('publication_permission') == 'author_only' ? 'selected' : '' }}>Только автор</option>
                    <option value="allowed" {{ old('publication_permission') == 'allowed' ? 'selected' : '' }}>Разрешено</option>
                    <option value="forbidden" {{ old('publication_permission') == 'forbidden' ? 'selected' : '' }}>Запрещено</option>
                </select>
                @error('publication_permission')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</div>
@endsection
