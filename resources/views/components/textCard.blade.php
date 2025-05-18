@props(['text'])


<div class=" p-4 border border-[#c49a6c] rounded-md">
    <h2 class="text-xl mb-2 flex items-center gap-2">
        <a href="{{ route('texts.show', $text->id) }}" class="hover:underline">{{ $text->title }}</a>

        @if ($text->age_rating && $text->age_rating !== '0+')
             <p><span class="text-xs px-1.5 py-0.5 rounded bg-orange-700 text-white">{{ $text->age_rating }}</span></p>
        @endif
    </h2>

    <div class="text-sm mb-2 flex items-center gap-2">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-6 8a6 6 0 0112 0H4z" />
        </svg>
        <a href="{{ route('user.profile', $text->user->id) }}" class="hover:underline">
            {{ $text->user->name }}
        </a>
    </div>

    <div class="mb-3">
        @include('components.tags', ['text' => $text])
    </div>

    <p class="mb-4 text-sm">
        {{ $text->description }}
    </p>

    @if ($text->categories && $text->categories->count())
        <div class="flex flex-wrap gap-2">
            @foreach ($text->categories as $category)
                <span class="inline-block text-xs px-2 py-1 rounded bg-[#BD7835] text-white">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>
    @endif
</div>