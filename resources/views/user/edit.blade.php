@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Редактирование профиля</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Имя пользователя</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Электронная почта</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Обновить профиль</button>
    </form>

    <hr>

    <h3>Изменить пароль</h3>
    <a href="{{ route('user.profile.change.password') }}" class="btn btn-secondary">Перейти к изменению пароля</a>
</div>
@endsection
