<div class="tab-pane fade show active" role="tabpanel" id="form-header">
    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', isset($text) ? $text->title : '') }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="description">Краткое описание</label>
        <textarea id="description" name="description" rows="4"
            class="form-control @error('description') is-invalid @enderror" required>{{ old('description', isset($text) ? $text->description : '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="genre_id">Жанр</label>
        <select id="genre_id" name="genre_id" class="form-control @error('genre_id') is-invalid @enderror" required>
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ old('genre_id', isset($text) ? $text->genre_id : '') == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
        @error('genre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
    <label for="category_id">Категории</label>
    <select id="category_id" name="category_id[]" class="form-control @error('category_id') is-invalid @enderror" multiple required>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" 
                {{ (collect(old('category_id', isset($text) ? $text->categories->pluck('id')->toArray() : []))->contains($category->id)) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

    <div class="form-group">
        <label for="tags">Теги (через запятую)</label>
        <input type="text" id="tags" name="tags" class="form-control @error('tags') is-invalid @enderror"
            value="{{ old('tags', isset($text) ? $text->tags : '') }}">
        @error('tags')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="status">Статус</label>
        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
            <option value="in progress" {{ old('status', isset($text) ? $text->status : '') == 'in progress' ? 'selected' : '' }}>В процессе</option>
            <option value="completed" {{ old('status', isset($text) ? $text->status : '') == 'completed' ? 'selected' : '' }}>Завершено</option>
            <option value="frozen" {{ old('status', isset($text) ? $text->status : '') == 'frozen' ? 'selected' : '' }}>Заморожено</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="size">Размер</label>
        <select id="size" name="size" class="form-control @error('size') is-invalid @enderror" required>
            <option value="mini" {{ old('size', isset($text) ? $text->size : '') == 'mini' ? 'selected' : '' }}>Мини</option>
            <option value="standard" {{ old('size', isset($text) ? $text->size : '') == 'standard' ? 'selected' : '' }}>Стандарт</option>
            <option value="maxi" {{ old('size', isset($text) ? $text->size : '') == 'maxi' ? 'selected' : '' }}>Макси</option>
        </select>
        @error('size')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="warnings">Предупреждения</label>
        <textarea id="warnings" name="warnings" rows="4"
            class="form-control @error('warnings') is-invalid @enderror">{{ old('warnings', isset($text) ? $text->warnings : '') }}</textarea>
        @error('warnings')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="age_rating">Возрастной рейтинг</label>
        <input type="text" id="age_rating" name="age_rating"
            class="form-control @error('age_rating') is-invalid @enderror" value="{{ old('age_rating', isset($text) ? $text->age_rating : '0+') }}">
        @error('age_rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="dedication">Посвящение</label>
        <input type="text" id="dedication" name="dedication"
            class="form-control @error('dedication') is-invalid @enderror" value="{{ old('dedication', isset($text) ? $text->dedication : '') }}">
        @error('dedication')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="publication_permission">Разрешение на публикацию</label>
        <select id="publication_permission" name="publication_permission"
            class="form-control @error('publication_permission') is-invalid @enderror" required>
            <option value="author_only" {{ old('publication_permission', isset($text) ? $text->publication_permission : '') == 'author_only' ? 'selected' : '' }}>
                Только автор</option>
            <option value="allowed" {{ old('publication_permission', isset($text) ? $text->publication_permission : '') == 'allowed' ? 'selected' : '' }}>
                Разрешено</option>
            <option value="forbidden" {{ old('publication_permission', isset($text) ? $text->publication_permission : '') == 'forbidden' ? 'selected' : '' }}>
                Запрещено</option>
        </select>
        @error('publication_permission')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

