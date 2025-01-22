<nav class="navbar">
    <div class="container">
        <a href="{{ route('home.index') }}" class="navbar-brand">Writer's Hub</a>
        <ul class="navbar-nav">
            @guest
                <li><a href="{{ route('login') }}">Вход</a></li>
                <li><a href="{{ route('register') }}">Регистрация</a></li>
            @else
                <li><a href="{{ route('texts.index') }}">Все тексты</a></li>
                <li><a href="{{ route('user.dashboard') }}">Личный кабинет</a></li>
                @if (auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}">Админка</a></li>
                @endif
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Выход</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>
