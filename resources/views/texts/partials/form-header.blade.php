@php
    $selectedCategories = collect(old('category_id', isset($text) ? $text->categories->pluck('id')->toArray() : []));
@endphp

<div class="tab-pane fade show active space-y-6" role="tabpanel" id="form-header">
     
    <div class="space-y-2">
        <label for="title" class="font-semibold">Название</label>
        <input type="text" id="title" name="title"
            class="w-full rounded px-4 py-2 border @error('title') border-red-500 @else border-gray-300 @enderror"
            value="{{ old('title', isset($text) ? $text->title : '') }}" required>
        @error('title')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="description" class="font-semibold">Краткое описание</label>
        <textarea id="description" name="description" rows="4"
            class="w-full rounded px-4 py-2 border @error('description') border-red-500 @else border-gray-300 @enderror"
            required>{{ old('description', isset($text) ? $text->description : '') }}</textarea>
        @error('description')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="genre_id" class="font-semibold">Жанр</label>
        <select id="genre_id" name="genre_id"
            class="w-full rounded px-4 py-2 border @error('genre_id') border-red-500 @else border-gray-300 @enderror"
            required>
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ old('genre_id', isset($text) ? $text->genre_id : '') == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
        @error('genre_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="category_id" class="font-semibold">Категории</label>
        <select id="category_id" name="category_id[]" multiple
            class="w-full rounded px-4 py-2 border @error('category_id') border-red-500 @else border-gray-300 @enderror"
            required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $selectedCategories->contains($category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="tags" class="font-semibold">Теги (через запятую)</label>
        <input type="text" id="tags" name="tags"
            class="w-full rounded px-4 py-2 border @error('tags') border-red-500 @else border-gray-300 @enderror"
            value="{{ old('tags', isset($text) ? $text->tags : '') }}">
        @error('tags')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="status" class="font-semibold">Статус</label>
        <select id="status" name="status"
            class="w-full rounded px-4 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror"
            required>
            <option value="in progress" {{ old('status', isset($text) ? $text->status : '') == 'in progress' ? 'selected' : '' }}>В процессе</option>
            <option value="completed" {{ old('status', isset($text) ? $text->status : '') == 'completed' ? 'selected' : '' }}>Завершено</option>
            <option value="frozen" {{ old('status', isset($text) ? $text->status : '') == 'frozen' ? 'selected' : '' }}>Заморожено</option>
        </select>
        @error('status')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="size" class="font-semibold">Размер</label>
        <select id="size" name="size"
            class="w-full rounded px-4 py-2 border @error('size') border-red-500 @else border-gray-300 @enderror"
            required>
            <option value="mini" {{ old('size', isset($text) ? $text->size : '') == 'mini' ? 'selected' : '' }}>Мини</option>
            <option value="standard" {{ old('size', isset($text) ? $text->size : '') == 'standard' ? 'selected' : '' }}>Стандарт</option>
            <option value="maxi" {{ old('size', isset($text) ? $text->size : '') == 'maxi' ? 'selected' : '' }}>Макси</option>
        </select>
        @error('size')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="warnings" class="font-semibold">Предупреждения</label>
        <textarea id="warnings" name="warnings" rows="4"
            class="w-full rounded px-4 py-2 border @error('warnings') border-red-500 @else border-gray-300 @enderror">{{ old('warnings', isset($text) ? $text->warnings : '') }}</textarea>
        @error('warnings')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="age_rating" class="font-semibold">Возрастной рейтинг</label>
        <input type="text" id="age_rating" name="age_rating"
            class="w-full rounded px-4 py-2 border @error('age_rating') border-red-500 @else border-gray-300 @enderror"
            value="{{ old('age_rating', isset($text) ? $text->age_rating : '0+') }}">
        @error('age_rating')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="dedication" class="font-semibold">Посвящение</label>
        <input type="text" id="dedication" name="dedication"
            class="w-full rounded px-4 py-2 border @error('dedication') border-red-500 @else border-gray-300 @enderror"
            value="{{ old('dedication', isset($text) ? $text->dedication : '') }}">
        @error('dedication')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-2">
        <label for="publication_permission" class="font-semibold">Разрешение на публикацию</label>
        <select id="publication_permission" name="publication_permission"
            class="w-full rounded px-4 py-2 border @error('publication_permission') border-red-500 @else border-gray-300 @enderror"
            required>
            <option value="author_only" {{ old('publication_permission', isset($text) ? $text->publication_permission : '') == 'author_only' ? 'selected' : '' }}>Только автор</option>
            <option value="allowed" {{ old('publication_permission', isset($text) ? $text->publication_permission : '') == 'allowed' ? 'selected' : '' }}>Разрешено</option>
            <option value="forbidden" {{ old('publication_permission', isset($text) ? $text->publication_permission : '') == 'forbidden' ? 'selected' : '' }}>Запрещено</option>
        </select>
        @error('publication_permission')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

</div>
