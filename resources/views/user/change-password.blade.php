@extends('layouts.app')

@section('content')
    <div class=" mx-auto mt-20 px-6">
        <x-back page="Изменение пароля" />

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

        {{-- Ошибки --}}
        @if ($errors->any())
            <div
                class="bg-[#FDE2E2] border border-red-400 text-red-800 rounded-lg px-6 py-4 mb-6 text-base font-medium shadow-md flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 mt-1 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M4.93 19.07L19.07 4.93" />
                </svg>
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Форма изменения пароля --}}
        <form action="{{ route('user.profile.update-password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-base font-semibold text-muted mb-2">Текущий пароль:</label>
                <input type="password" id="current_password" name="current_password" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

            <div>
                <label for="password" class="block text-base font-semibold text-muted mb-2">Новый пароль:</label>
                <input type="password" id="password" name="password" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

            <div>
                <label for="password_confirmation" class="block text-base font-semibold text-muted mb-2">Подтверждение пароля:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

            <button type="submit"
                class="btn text-lg w-full bg-action text-white py-3 rounded hover:bg-actionHover transition">
                Обновить пароль
            </button>
        </form>
    </div>
@endsection
