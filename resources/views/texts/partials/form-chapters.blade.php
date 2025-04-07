<div id="form-chapters" style="display: none;">
    <form action="{{ route('chapter.store', ['text_id' => $text->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if (isset($previousChapters) && count($previousChapters))
            <div class="mb-4">
                <h5>Предыдущие главы</h5>
                <ul class="list-group">
                    @foreach ($previousChapters as $chapter)
                        <li class="list-group-item">{{ $chapter->title }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="text_file">Загрузить текстовый файл (.txt, .docx)</label>
            <input type="file" id="text_file" name="text_file" accept=".txt,.docx" class="form-control">
            <button type="button" id="edit_docx" class="btn btn-warning mt-2" style="display: none;">Редактировать</button>
        </div>

        <div class="form-group" id="text_container">
            <label for="content">Полный текст</label>
            <textarea id="content" name="content" rows="8" class="form-control" required>{{ old('content') }}</textarea>
        </div>

        <div class="text-right mt-4">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
