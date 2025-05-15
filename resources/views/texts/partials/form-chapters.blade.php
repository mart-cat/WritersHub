<div id="form-chapters">

 {{-- Навигация по главам --}}
 <div class="mt-5">
            <h3>Список глав</h3>

            @if ($previousChapters->isEmpty())
                <p>Нет доступных глав для редактирования.</p>
            @else
                <ul class="list-group" id="chapter-list">
                    @foreach ($previousChapters as $chapter)
                        <li class="list-group-item d-flex justify-content-between align-items-center chapter-item"
                            data-id="{{ $chapter->id }}"
                            data-title="{{ $chapter->title }}"
                            data-content="{{ $chapter->content }}">
                            
                            <a href="{{ route('chapter.save', ['text_id' => $text->id, 'id' => $chapter->id]) }}" class="btn btn-warning btn-sm">{{ $chapter->title }}</a>

                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Кнопка для добавления новой главы --}}
        <div class="text-right mt-4">
            <a href="{{ route('chapter.save', $text->id) }}" class="btn btn-success">Новая глава</a>
        </div>
    </div>
</div>
