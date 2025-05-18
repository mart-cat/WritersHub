@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')

<div class="relative w-full">
  <!-- Фон с охватом всей ширины + под шапкой -->
<div class="absolute inset-0 z-0 bg-no-repeat bg-top"
     style="background-image: url('/images/Backround-first-page.png'); background-size: 100% auto;"></div>


  <!-- Контейнер с контентом -->
  <div class="relative z-10 max-w-7xl mx-auto min-h-[760px] flex flex-col justify-center items-center text-center px-4 pt-32">
    <h1 class="text-[128px] mb-0">ПЕРО</h1>
    <h2 class="text-5xl mb-6">раскрывает новые миры</h2>
    <p class="max-w-2xl text-lg font-bold text-[#5a3d2b]">
      Здесь, в уютном уголке виртуального мира, мы открываем новые горизонты для чтения, обсуждения и вдохновения. Наш
      проект создан для всех тех, кто хочет не просто читать, но и делиться своими мыслями о книгах, находить свежие
      идеи и открывать для себя новые произведения.
    </p>
  </div>
</div>



   
    <div class="py-12">
        <div class="max-w-4xl mx-auto text-center">
            <h3 class="text-2xl mb-6">Найдите то что интересует именно вас</h3>
            <form action="{{ route('texts.filter') }}" method="GET"
                class="flex flex-col md:flex-row justify-center items-center gap-4">
                <select name="genre" class="border border-[#c49a6c] text-normal front-nunito rounded px-4 py-2 bg-[#FDECB3]">
                    <option value="">Жанр</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="">Поиск</button>
            </form>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-3xl mx-auto text-center">
            <h3 class="text-2xl mb-4">О проекте</h3>
            <p class=" leading-relaxed text-justify">
                <strong>ПЕРО</strong> — это сайт, где каждый может стать автором. Мы открываем двери для всех, кто хочет
                делиться своими историями, повестями, романами и стихами. На платформе можно не только публиковать свои
                работы, но и получать обратную связь, советы и вдохновение от других пользователей. <br><br>
                Здесь каждый автор, независимо от его опыта, может найти место для своего творчества, а читатели — открывать
                новые горизонты в мире литературы.
            </p>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-3xl mx-auto">
            <h3 class="text-2xl text-primary text-center mb-4">Как начать?</h3>
            <ol class="list-decimal list-inside space-y-2 text-lg text-normal">
                <li><a href="{{ route('register') }}" class="text-action underline">Зарегистрируйтесь</a> и создайте
                    профиль.</li>
                <li>Загружайте свои работы и получайте отзывы.</li>
                <li>Читайте произведения других авторов и оставляйте свои рецензии.</li>
                <li>Будьте частью литературного сообщества и развивайтесь вместе с нами!</li>
            </ol>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-3xl mx-auto">
            <h3 class="text-2xl text-[#6b3f1d] text-center mb-4">Правила проекта:</h3>
            <div class="text-[#5a3d2b] space-y-4">
                <p><strong>Уважение и доброжелательность.</strong> Мы создаем безопасное пространство для творчества, где
                    конструктивная критика приветствуется, но нет места оскорблениям.</p>
                <p><strong>Авторские права.</strong> Публикуйте только те работы, на которые у вас есть права.</p>
                <p><strong>Честность и открытость.</strong> Оценивайте искренне, развивайте авторов.</p>
                <p><strong>Литературный контент.</strong> Только художественные материалы. Без политики, рекламы и
                    провокаций.</p>
                <p><strong>Обратная связь и обсуждения.</strong> Поддержка — ключ к росту писателя.</p>
                <p><strong>Право на блокировку.</strong> Мы можем ограничивать доступ при нарушениях.</p>
            </div>
        </div>
    </div> 


@endsection