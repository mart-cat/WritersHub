@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Изменение пароля</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.profile.update-password') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="current_password">Текущий пароль</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Новый пароль</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Обновить пароль</button>
    </form>
</div>
@endsection
