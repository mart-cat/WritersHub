@extends('layouts.app')

@section('content')
    <h1>Управление пользователями</h1>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.users.search') }}" method="GET">
    <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="Введите email" required>
    <button type="submit">Поиск</button>
</form>

    <div class="row">
        @foreach($users as $user)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">Email: {{ $user->email }}</p>
                        
                        <p class="card-text">
                            Статус:
                            @if($user->is_blocked)
                                @if($user->blocked_until && $user->blocked_until > now())
                                    Заблокирован до {{ $user->blocked_until }}
                                @else
                                    Заблокирован навсегда
                                @endif
                            @else
                                Активен
                            @endif
                        </p>

                        <div class="d-flex justify-content-between">
                            <div>
                                @if(!$user->is_blocked)
                                    <!-- Форма для временной блокировки -->
                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <input type="datetime-local" name="blocked_until" required class="form-control form-control-sm d-inline-block" style="width: 150px;">
                                        <button type="submit" class="btn btn-warning btn-sm ml-2">Заблокировать временно</button>
                                    </form>
                                    <!-- Форма для постоянной блокировки -->
                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="d-inline-block mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Заблокировать навсегда</button>
                                    </form>
                                @else
                                    <!-- Форма для разблокировки -->
                                    <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="d-inline-block mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Разблокировать</button>
                                    </form>
                                @endif
                            </div>

                            <!-- Форма для удаления пользователя -->
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline-block mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
