@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Вход</h2>

    <div id="error-message" class="alert alert-danger d-none"></div>

    <form id="login-form">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>

    <!-- Блок 2FA (изначально скрыт) -->
    <div id="two-factor-section" class="d-none">
        <h3>Введите код подтверждения</h3>
        <form id="two-factor-form">
            @csrf
            <div class="form-group">
                <label for="two_factor_code">Код из письма:</label>
                <input type="text" name="two_factor_code" id="two_factor_code" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Подтвердить</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();
        $('#error-message').addClass('d-none');

        $.ajax({
            url: "{{ route('login.ajax') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#login-form').hide();
                    $('#two-factor-section').removeClass('d-none');
                }
            },
            error: function(xhr) {
                $('#error-message').text(xhr.responseJSON.error).removeClass('d-none');
            }
        });
    });

    $('#two-factor-form').submit(function(e) {
        e.preventDefault();
        $('#error-message').addClass('d-none');

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
                $('#error-message').text(xhr.responseJSON.error).removeClass('d-none');
            }
        });
    });
});
</script>
@endsection
