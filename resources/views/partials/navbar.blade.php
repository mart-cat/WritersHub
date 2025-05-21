<!-- Шапка -->
<div class="relative w-full z-50">
  <nav class="w-full absolute top-0 left-0 z-40">
    <div class="max-w-5xl mx-auto px-4 py-4 flex justify-between items-center">
      <a href="{{ route('home.index') }}" class="text-2xl font-bold text-[#6b3f1d]">ПЕРО</a>

      <!-- Бургер -->
      <div class="md:hidden cursor-pointer" onclick="toggleMenu()">
        <div class="w-6 h-0.5 bg-[#6b3f1d] mb-1"></div>
        <div class="w-6 h-0.5 bg-[#6b3f1d] mb-1"></div>
        <div class="w-6 h-0.5 bg-[#6b3f1d]"></div>
      </div>

      <!-- Десктоп-меню -->
      <ul class="hidden md:flex space-x-6 text-[#5a3d2b] font-medium">
        @guest
      <li><a href="{{ route('login') }}" class="hover:underline">Вход</a></li>
      <li><a href="{{ route('register') }}" class="hover:underline">Регистрация</a></li>
    @else

        @if (auth()->user()->role === 'admin')
        <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">Панель управления</a></li>
      @elseif (auth()->user()->role === 'editor')
        <li><a href="{{ route('editor.dashboard') }}" class="hover:underline">Рабочее пространство</a></li>
      @else
        <a href="{{ route('user.dashboard') }}" class="block hover:underline">Личный кабинет</a>
      @endif
        <li>
          <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="hover:underline">Выход</button>
          </form>
        </li>
    @endguest
      </ul>
    </div>
  </nav>

  <!-- Мобильное меню -->

  <div id="mobileMenu"
    class="md:hidden hidden  left-0 w-full  text-[#5a3d2b] font-medium px-4 py-4 space-y-3 z-50 mt-8">
    <div class="">
      @guest
      <a href="{{ route('login') }}" class="block hover:underline">Вход</a>
      <a href="{{ route('register') }}" class="block hover:underline">Регистрация</a>
    @else
      <a href="{{ route('texts.index') }}" class="block hover:underline">Все тексты</a>

      @if (auth()->user()->role === 'admin')
      <a href="{{ route('admin.dashboard') }}" class="block hover:underline">Панель управления</a>
    @elseif (auth()->user()->role === 'editor')
      <a href="{{ route('editor.dashboard') }}" class="block hover:underline">Рабочее пространство</a>
    @else
      <a href="{{ route('user.dashboard') }}" class="block hover:underline">Личный кабинет</a>
    @endif
      <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="text-[#a4532c] hover:text-[#873b1c]">Выход</button>
      </form>
    @endguest
    </div>
  </div>
</div>
<script>
  function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
  }
</script>