@props(['text'])

    @if ($text->status === 'in progress' )
                <span class="bg-green-700 text-white text-sm px-2 py-1 rounded">В процессе</span>
            @elseif ($text->status === 'completed' )
                <span class="bg-yellow-700 text-white text-sm px-2 py-1 rounded">Завершен</span>
            @else
                <span class="bg-blue-700 text-white text-sm px-2 py-1 rounded">Заморожен</span>
    @endif
                <span class="bg-orange-800 text-white text-sm px-2 py-1 rounded">{{ $text->genre->name }}</span>