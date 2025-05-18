@props(['title'])
<div class="relative w-full ">
    <div class="absolute inset-0 z-0 bg-no-repeat bg-cover bg-center"
         style="background-image: url('/images/Backround-base.png')"></div>

    <div class="relative z-10 max-w-7xl mx-auto flex flex-col justify-center items-center text-center px-4 py-20 min-h-[40vh]">
        <h2 class="text-5xl mb-6">{{ $title }}</h2>
        {{ $slot }}
    </div>
</div>
