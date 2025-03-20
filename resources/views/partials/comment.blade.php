<div class="mb-3 comment-container" data-comment-id="{{ $comment->id }}">
    <p class="mb-1">
        <strong>
            <a href="{{ route('user.profile', $comment->user->id) }}">{{ $comment->user->name }}</a>
        </strong>
        <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
    </p>
    <p>{{ $comment->content }}</p>

    @auth
        <a href="javascript:void(0);" class="reply-btn text-primary" data-comment-id="{{ $comment->id }}" data-user-name="{{ $comment->user->name }}">Ответить</a>
        <div class="reply-form-container"></div>
    @endauth

    @if ($comment->replies->isNotEmpty())
        <div class="ms-4 mt-2 comment-reply">
            @foreach ($comment->replies as $reply)
                @include('partials.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
