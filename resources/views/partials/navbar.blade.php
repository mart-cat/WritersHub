<nav class="">
    <div class=" fixed left-11 right-20 z-50 max-w-5xl mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home.index') }}" class="text-2xl font-bold text-[#6b3f1d]">ПЕРО</a>

        <div class="md:hidden" onclick="toggleMenu()">
            <div class="w-6 h-0.5 bg-[#6b3f1d] mb-1"></div>
            <div class="w-6 h-0.5 bg-[#6b3f1d] mb-1"></div>
            <div class="w-6 h-0.5 bg-[#6b3f1d]"></div>
        </div>

        <ul class="hidden md:flex space-x-6 text-[#5a3d2b] font-medium">
            @guest
                <li><a href="{{ route('login') }}" class="hover:underline">Вход</a></li>
                <li><a href="{{ route('register') }}" class="hover:underline">Регистрация</a></li>
            @else
                <li><a href="{{ route('user.dashboard') }}" class="hover:underline">Личный кабинет</a></li>

                @if (auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Панель управления</a></li>
                @elseif (auth()->user()->role === 'editor')
                    <li><a href="{{ route('editor.dashboard') }}" class="hover:underline">Рабочее пространство</a></li>
                @endif

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-white">Выход</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>

    <!-- Mobile Menu -->
    <ul class="md:hidden px-4 pb-4 space-y-2 text-[#5a3d2b] font-medium hidden" id="mobileMenu">
        @guest
            <li><a href="{{ route('login') }}" class="block">Вход</a></li>
            <li><a href="{{ route('register') }}" class="block">Регистрация</a></li>
        @else
            <li><a href="{{ route('texts.index') }}" class="block">Все тексты</a></li>
            <li><a href="{{ route('user.dashboard') }}" class="block">Личный кабинет</a></li>

            @if (auth()->user()->role === 'admin')
                <li><a href="{{ route('admin.dashboard') }}" class="block">Панель управления</a></li>
            @elseif (auth()->user()->role === 'editor')
                <li><a href="{{ route('editor.dashboard') }}" class="block">Рабочее пространство</a></li>
            @endif

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-[#a4532c] hover:text-[#873b1c]">Выход</button>
                </form>
            </li>
        @endguest
    </ul>
</nav>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }
</script>
