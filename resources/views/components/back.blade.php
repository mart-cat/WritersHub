@props(['page'])
<div class='flex mt-20'>
            <a href="javascript:history.back()" class="inline-flex items-center text-orange-700 hover:underline mb-4"> ←
            </a>
            <h1 class="text-4xl  mb-6">{{$page}}</h1>
</div>
{{ $slot }}