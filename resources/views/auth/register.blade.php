@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-20 px-6">
        <h2 class="text-3xl font-orelega text-center mb-8">Регистрация</h2>

        {{-- Ошибка --}}
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

        {{-- Форма регистрации --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-base font-semibold text-muted mb-2">Имя:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

            <div>
                <label for="email" class="block text-base font-semibold text-muted mb-2">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

            <div>
                <label for="password" class="block text-base font-semibold text-muted mb-2">Пароль:</label>
                <input type="password" id="password" name="password" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

            <div>
                <label for="password_confirmation" class="block text-base font-semibold text-muted mb-2">Подтвердите
                    пароль:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>

<div class="flex items-center gap-2 mb-4">
    <input type="checkbox" name="terms" id="terms" required class="w-5 h-5 accent-action shrink-0">
    <label for="terms" class="text-sm text-muted">
        Я принимаю <a href="#" class="text-action underline">пользовательское соглашение</a>
    </label>
</div>


<button type="submit"
        class="btn text-lg w-full bg-action text-white py-3 rounded hover:bg-actionHover transition">
    Зарегистрироваться
</button>


        </form>
    </div>
@endsection