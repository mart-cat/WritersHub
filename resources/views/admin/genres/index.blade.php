@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">

    <x-back page="Жанры" />

    {{-- Форма добавления жанра --}}
    <div class="bg-[#FDECB3] mb-8">
        <form action="{{ route('admin.genres.store') }}" method="POST" class="flex flex-col md:flex-row items-center gap-4">
            @csrf
            <input type="text" name="name" placeholder="Название жанра" required
                   class="w-full md:flex-1 px-4 py-2 rounded border border-borderGold bg-white focus:outline-none focus:ring-2 focus:ring-action">
            <button type="submit"
                    class="bg-action text-white px-6 py-2 rounded hover:bg-actionHover transition">Добавить</button>
        </form>
    </div>

    {{-- Список жанров --}}
    <ul class="space-y-4">
        @foreach($genres as $genre)
            <li class="bg-[#FDECB3] p-4 rounded border border-borderGold flex justify-between items-center">
                <span class="font-semibold text-lg">{{ $genre->name }}</span>
                <form action="{{ route('admin.genres.delete', $genre->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 transition text-sm">Удалить</button>
                </form>
            </li>
        @endforeach
    </ul>

</div>
@endsection
