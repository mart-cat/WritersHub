@extends('layouts.app')

@section('title', 'Список текстов')

@section('content')
    <x-page-header title="Рассказы"></x-page-header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 z-10 relative">

        <!-- Кнопка фильтра для мобильных -->
        <button onclick="toggleFilters()" class="md:hidden px-4 py-2 mb-4 bg-yellow-700 text-white rounded">
            Фильтры
        </button>

        <div class="md:flex md:space-x-6">
            <!-- Фильтры -->
            <div id="filtersPanel" class=" md:w-auto hidden md:block">
                <form method="GET" action="{{ route('texts.filter') }}" class="p-6 rounded-lg mb-8">
                    <h2 class="text-2xl font-orelega mb-4">Фильтры</h2>

                    <div class="flex flex-col gap-6 max-w-xs">
                        <!-- Жанр -->
                        <div>
                            <h3 class="mb-2">Жанр</h3>
                            <select name="genre"
                                class="border border-[#c49a6c] text-normal front-nunito rounded px-4 py-2 bg-[#FDECB3]">
                                <option value="">Жанр</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Статус -->
                        <div>
                            <h3 class="mb-2">Статус работы</h3>
                            <div class="flex flex-col gap-2">
                                @php $statuses = request('status', []); @endphp
                                @foreach(['Заморожен', 'В процессе', 'Завершен'] as $status)
                                    <label class="inline-flex items-center gap-2">
                                        <input type="checkbox" name="status[]" value="{{ $status }}"
                                            class="w-5 h-5 accent-yellow-700" {{ in_array($status, $statuses) ? 'checked' : '' }}>
                                        {{ $status }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Размер -->
                        <div>
                            <h3 class="mb-2">Размер</h3>
                            <div class="flex flex-col gap-2">
                                @php $sizes = request('size', []); @endphp
                                @foreach(['Мини', 'Миди', 'Макси'] as $size)
                                    <label class="inline-flex items-center gap-2">
                                        <input type="checkbox" name="size[]" value="{{ $size }}"
                                            class="w-5 h-5 accent-yellow-700" {{ in_array($size, $sizes) ? 'checked' : '' }}>
                                        {{ $size }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Категории -->
                        <div>
                            <h3 class="mb-2">Категории</h3>
                            <select name="category[]" multiple
                                class="w-full border border-yellow-600 rounded px-4 py-2 bg-white">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ collect(request('category'))->contains($category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Кнопка -->
                        <div class="mt-4">
                            <button type="submit" class="px-6 py-2 rounded bg-orange-700 text-white hover:bg-orange-800">
                                Поиск
                            </button>
                        </div>
                    </div>
                </form>
            </div>


        <!-- Список рассказов -->
        <div class="space-y-6 w-full">
            @foreach ($texts as $text)
                @include('components.textCard', ['text' => $text])
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="mt-8">
            @include('components.pagination', ['paginator' => $texts])
        </div>
    </div>
    </div>
@endsection

<script>
    function toggleFilters() {
        const panel = document.getElementById('filtersPanel');
        panel.classList.toggle('hidden');
    }
</script>