@extends('layouts.app')

@section('content')


{{--<x-page-header title="Вход" />--}}
<div class="max-w-lg mx-auto mt-20 px-6">
    <h2 class="text-3xl font-orelega text-center mb-8">Вход</h2>

    {{-- Ошибка --}}
<div id="error-message"
     class="hidden bg-[#FDE2E2] border border-red-400 text-red-800 rounded-lg px-6 py-4 mb-6 text-base font-medium shadow-md flex items-start gap-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 mt-1 text-red-500" fill="none" viewBox="0 0 24 24"
         stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M4.93 19.07L19.07 4.93" />
    </svg>
    <span id="error-text">Что-то пошло не так</span>
</div>


    {{-- Форма входа --}}
    <form id="login-form" class=" space-y-6" method="POST">
        @csrf

        <div>
            <label for="email" class="block text-base font-semibold text-muted mb-2">Email:</label>
            <input type="email" name="email" id="email" required
                   class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
        </div>

        <div>
            <label for="password" class="block text-base font-semibold text-muted mb-2">Пароль:</label>
            <input type="password" name="password" id="password" required
                   class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
        </div>

        <button type="submit"
                class="btn text-lg w-full bg-action text-white py-3 rounded hover:bg-actionHover transition">Войти</button>
    </form>

    {{-- Форма 2FA --}}
    <div id="two-factor-section" class="bg-[#FDECB3] shadow-md rounded p-8 mt-8 hidden">
        <h3 class="text-xl font-bold text-normal mb-6">Введите код подтверждения</h3>
        <form id="two-factor-form" method="POST">
            @csrf
            <div class="mb-6">
                <label for="two_factor_code" class="block text-base font-semibold text-muted mb-2">Код из письма:</label>
                <input type="text" name="two_factor_code" id="two_factor_code" required
                       class="w-full text-lg border border-borderGold rounded px-5 py-3 bg-[#FDECB3] focus:outline-none focus:ring-2 focus:ring-action">
            </div>
            <button type="submit"
                    class="btn text-lg w-full bg-action text-white py-3 rounded hover:bg-actionHover transition">Подтвердить</button>
        </form>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();
        $('#error-message').addClass('hidden');

        $.ajax({
            url: "{{ route('login.ajax') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#login-form').hide();
                    $('#two-factor-section').removeClass('hidden');
                }
            },
            error: function(xhr) {
                $('#error-message').text(xhr.responseJSON.error).removeClass('hidden');
            }
        });
    });

    $('#two-factor-form').submit(function(e) {
        e.preventDefault();
        $('#error-message').addClass('hidden');

        $.ajax({
            url: "{{ route('2fa.verify.ajax') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = "{{ route('home.index') }}";
                }
            },
            error: function(xhr) {
                $('#error-message').text(xhr.responseJSON.error).removeClass('hidden');
            }
        });
    });
});

</script>
@endsection
