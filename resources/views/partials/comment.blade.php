<div class="mb-4 p-4 border border-gray-300 rounded bg-comment comment-container" data-comment-id="{{ $comment->id }}">
    <div class="flex justify-between items-center mb-2">
        <div class="text-sm">
            <a href="{{ route('user.profile', $comment->user->id) }}" class="font-semibold hover:underline">
                {{ $comment->user->name }}
            </a>
            <span class="text-xs ml-2">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
        </div>
    </div>

    <p class="whitespace-pre-line">{{ $comment->content }}</p>

    @auth
        <a href="javascript:void(0);" 
           class="reply-btn inline-block mt-2 text-sm hover:underline" 
           data-comment-id="{{ $comment->id }}" 
           data-user-name="{{ $comment->user->name }}">
            Ответить
        </a>
        <div class="reply-form-container mt-2"></div>
    @endauth

    @if ($comment->replies->isNotEmpty())
        <div class="ml-4 border-l-2 border-gray-300 pl-4 mt-4 space-y-3 comment-reply">
            @foreach ($comment->replies as $reply)
                @include('partials.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
