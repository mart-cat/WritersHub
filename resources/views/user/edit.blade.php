@extends('layouts.app')

@section('content')
    <div class=" mx-auto mt-20 px-6">
        {{-- Назад и заголовок --}}
        <x-back page="Редактирование профиля" />

        {{-- Успешное сообщение --}}
        @if (session('success'))
            <div
                class="bg-green-100 border border-green-400 text-green-800 rounded-lg px-6 py-4 mb-6 text-base font-medium shadow-md flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 mt-1 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Форма обновления профиля --}}
        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-base font-semibold text-muted mb-2">Имя пользователя:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

            <div>
                <label for="email" class="block text-base font-semibold text-muted mb-2">Электронная почта:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

            <button type="submit"
                class="btn text-lg w-full bg-action text-white py-3 rounded hover:bg-actionHover transition">
                Обновить профиль
            </button>
        </form>

        {{-- Смена пароля --}}
        <hr class="my-10 border-borderGold">

        <h3 class="text-xl font-semibold text-center mb-4">Изменить пароль</h3>
        <a href="{{ route('user.profile.change.password') }}"
            class="block text-center bg-action  transition text-white py-3 rounded text-lg">
            Перейти к изменению пароля
        </a>
    </div>
@endsection
