@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <x-back page="Управление текстами" />

    {{-- Успешное сообщение --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Поиск и фильтры --}}
    <form method="GET" action="{{ route('admin.texts') }}" class="grid md:grid-cols-6 gap-4 mb-8">
        <input type="text" name="author" value="{{ request('author') }}" placeholder="Автор"
               class="px-4 py-2 border border-borderGold rounded   col-span-2">
        <input type="text" name="title" value="{{ request('title') }}" placeholder="Название"
               class="px-4 py-2 border border-borderGold rounded   col-span-2">
        <select name="genre" class="px-4 py-2 border border-borderGold rounded  ">
            <option value="">Жанр</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}" @selected(request('genre') == $genre->id)>{{ $genre->name }}</option>
            @endforeach
        </select>
        <select name="status" class="px-4 py-2 border border-borderGold rounded  ">
            <option value="">Статус</option>
            <option value="in progress" @selected(request('status') === 'in progress')>В процессе</option>
            <option value="completed" @selected(request('status') === 'completed')>Завершён</option>
            <option value="frozen" @selected(request('status') === 'frozen')>Заморожен</option>
        </select>

        <div class="md:col-span-6 text-right">
            <button type="submit"
                    class="mt-2 bg-action text-white px-6 py-2 rounded hover:bg-actionHover transition">
                Поиск
            </button>
        </div>
    </form>

    {{-- Таблица текстов --}}
    <div class="overflow-x-auto">
        <table class="w-full border border-borderGold text-left  ">
            <thead class="">
                <tr>
                    <th class="px-4 py-3 border border-borderGold">Заголовок</th>
                    <th class="px-4 py-3 border border-borderGold">Автор</th>
                    <th class="px-4 py-3 border border-borderGold">Жанр</th>
                    <th class="px-4 py-3 border border-borderGold">Размер</th>
                    <th class="px-4 py-3 border border-borderGold">Возраст</th>
                    <th class="px-4 py-3 border border-borderGold">Статус</th>
                    <th class="px-4 py-3 border border-borderGold">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($texts as $text)
                    <tr class="border-t border-borderGold">
                        
                        <td class="px-4 py-3 font-medium"><a href="{{ route('texts.show', $text->id) }}"
                               class="hover:underline">{{ $text->title }}</a></td>
                        <td class="px-4 py-3">
                            <a href="{{ route('user.profile', $text->user->id) }}" class="hover:underline">{{ $text->user->name }}</a><br>
                            <span class="text-sm text-gray-600">{{ $text->user->email }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $text->genre->name }}</td>
                        <td class="px-4 py-3">{{ ucfirst($text->size) }}</td>
                        <td class="px-4 py-3">{{ $text->age_rating }}</td>
                        <td class="px-4 py-3">{{ ucfirst($text->status) }}</td>
                        <td class="px-4 py-3 space-y-2">
                            <form action="{{ route('admin.delete', $text->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                {{-- Подключи нужный маршрут для блокировки текста или пользователя --}}
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-gray-600">Тексты не найдены</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
