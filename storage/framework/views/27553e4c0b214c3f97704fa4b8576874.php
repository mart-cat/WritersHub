<?php $__env->startSection('title', $text->title); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <!-- Заголовок и информация о работе -->
        <div class="mb-4">
            <h1><?php echo e($text->title); ?></h1>
            <p class="text-muted">
                <small>Автор: <a href="<?php echo e(route('user.profile', $text->user->id)); ?>"><?php echo e($text->user->name); ?></a></small> |
                <small>Жанр: <?php echo e($text->genre->name); ?></small> |
                <small>Категория: <?php echo e($text->category->name); ?></small> |
                <small>Статус: <?php echo e($text->status); ?></small> |
                <small>Последнее обновление: <?php echo e($text->last_updated); ?></small>
            </p>
        </div>

        <!-- Предупреждения -->
        <?php if($text->warnings): ?>
            <div class="alert alert-warning">
                <strong>Предупреждения:</strong> <?php echo e($text->warnings); ?>

            </div>
        <?php endif; ?>

        <!-- Описание -->
        <div class="mb-4">
            <h4>Описание</h4>
            <p><?php echo e($text->description); ?></p>
        </div>

        <!-- Основной контент -->
        <div class="mb-4">
            <h4>Содержание</h4>
            <p><?php echo nl2br(e($text->content)); ?></p>
        </div>

        <!-- Интерактивные элементы -->
        <div class="mb-4 d-flex justify-content-between">
            <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('favorites.toggle', $text->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-<?php echo e($isFavorite ? 'danger' : 'success'); ?>">
                        <?php echo e($isFavorite ? 'Удалить из избранного' : 'Добавить в избранное'); ?>

                    </button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Комментарии -->
        <div class="mt-5">
            <h4>Комментарии (<?php echo e($comments->count()); ?>)</h4>

            <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('comments.store', $text->id)); ?>" method="POST" class="mb-4">
                    <?php echo csrf_field(); ?>
                    <textarea name="content" class="form-control" rows="3" placeholder="Оставьте комментарий..." required></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Отправить</button>
                </form>
            <?php endif; ?>

            <?php if($comments->isEmpty()): ?>
                <p class="text-muted">Комментариев пока нет. Будьте первым!</p>
            <?php else: ?>
                <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-3 comment-container" data-comment-id="<?php echo e($comment->id); ?>">
                        <p class="mb-1">
                            <strong>
                                <a href="<?php echo e(route('user.profile', $comment->user->id)); ?>"><?php echo e($comment->user->name); ?></a>
                            </strong>
                            <small class="text-muted"><?php echo e($comment->created_at->format('d.m.Y H:i')); ?></small>
                        </p>
                        <p><?php echo e($comment->content); ?></p>

                        <?php if(auth()->guard()->check()): ?>
                            <a href="javascript:void(0);" class="reply-btn text-primary" data-comment-id="<?php echo e($comment->id); ?>" data-user-name="<?php echo e($comment->user->name); ?>">Ответить</a>
                        <?php endif; ?>

                        <!-- Ответы на комментарий -->
                        <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="ms-4 mt-2 comment-container comment-reply" data-comment-id="<?php echo e($reply->id); ?>">
                                <p class="mb-1">
                                    <strong>
                                        <a href="<?php echo e(route('user.profile', $reply->user->id)); ?>"><?php echo e($reply->user->name); ?></a>
                                    </strong>
                                    <small class="text-muted"><?php echo e($reply->created_at->format('d.m.Y H:i')); ?></small>
                                </p>
                                <p><span class="text-muted"><?php echo e($reply->parent->user->name); ?></span>, <?php echo e($reply->content); ?></p>

                                <?php if(auth()->guard()->check()): ?>
                                    <a href="javascript:void(0);" class="reply-btn text-primary" data-comment-id="<?php echo e($reply->id); ?>" data-user-name="<?php echo e($reply->user->name); ?>">Ответить</a>
                                <?php endif; ?>

                                <!-- Рекурсивное отображение ответов на ответы -->
                                <?php $__currentLoopData = $reply->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $replyReply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="ms-4 mt-2 comment-container comment-reply-more" data-comment-id="<?php echo e($replyReply->id); ?>">
                                        <p class="mb-1">
                                            <strong>
                                                <a href="<?php echo e(route('user.profile', $replyReply->user->id)); ?>"><?php echo e($replyReply->user->name); ?></a>
                                            </strong>
                                            <small class="text-muted"><?php echo e($replyReply->created_at->format('d.m.Y H:i')); ?></small>
                                        </p>
                                        <p><span class="text-muted"><?php echo e($replyReply->parent->user->name); ?></span>, <?php echo e($replyReply->content); ?></p>

                                        <?php if(auth()->guard()->check()): ?>
                                            <a href="javascript:void(0);" class="reply-btn text-primary" data-comment-id="<?php echo e($replyReply->id); ?>" data-user-name="<?php echo e($replyReply->user->name); ?>">Ответить</a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('reply-btn')) {
            let commentId = event.target.getAttribute('data-comment-id');
            let userName = event.target.getAttribute('data-user-name');

            let commentContainer = document.querySelector(`[data-comment-id='${commentId}']`);
            let existingForm = commentContainer.querySelector('.reply-form');

            // Закрытие формы, если она уже открыта
            if (existingForm && existingForm.style.display === 'block') {
                existingForm.style.display = 'none';
                return;
            }

            // Закрытие всех других форм
            document.querySelectorAll('.reply-form').forEach(form => {
                form.style.display = 'none';
            });

            // Открытие текущей формы
            if (existingForm) {
                existingForm.style.display = 'block';
            } else {
                let formHtml = `
                    <form action="<?php echo e(route('comments.store', $text->id)); ?>" method="POST" class="reply-form mt-2">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="parent_id" value="${commentId}">
                        <textarea name="content" class="form-control" rows="2" placeholder="Ответить пользователю ${userName}..." required></textarea>
                        <button type="submit" class="btn btn-secondary mt-2">Отправить</button>
                    </form>
                `;
                commentContainer.insertAdjacentHTML('beforeend', formHtml);
            }
        }
    });
});

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\as906\OneDrive\Рабочий стол\WritersHub-main\resources\views/texts/show.blade.php ENDPATH**/ ?>