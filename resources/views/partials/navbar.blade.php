<nav class="header">
    <div class="container navbar">
        <a href="{{ route('home.index') }}" class="navbar-brand">Writer's Hub</a>
        
        <div class="hamburger" onclick="toggleMenu()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <ul class="nav-menu">
            @guest
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Вход</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Регистрация</a></li>
            @else
                <li class="nav-item"><a href="{{ route('texts.index') }}" class="nav-link">Все тексты</a></li>
                <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link">Личный кабинет</a></li>
                @if (auth()->user()->role === 'admin')
                    <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Админка</a></li>
                @endif
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline">Выход</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<script>
function toggleMenu() {
    document.querySelector(".nav-menu").classList.toggle("active");
}
</script>
