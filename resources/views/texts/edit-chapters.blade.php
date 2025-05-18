    
@extends('layouts.app')

@section('title', 'Редактирование шапки')

@section('content')
<div class="container">
     <x-back page="Редактирование шапки" />

    <div class="card p-3">
        {{-- Вкладки --}}
        <ul class="nav nav-tabs mb-4" id="formTabs">
            <li class="nav-item">
                <a class="nav-link active" id="tab-header" href="{{ route('texts.edit', $text->id) }}">Шапка</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-chapters" href="{{ route('texts.all.chapters', $text->id) }}">Главы</a>
            </li>
        </ul>

        <form 
    id="chapter-form" 
    action="{{ isset($chapter) 
        ? route('chapter.store', ['text_id' => $text->id, 'id' => $chapter->id]) 
        : route('chapter.store', ['text_id' => $text->id]) 
    }}" 
    method="POST" 
    enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="_method" value="POST" id="form-method">
        <input type="hidden" name="chapter_id" id="chapter_id">

        <div class="form-group">
            <label for="title">Название главы</label>
            <input id="title" name="title" class="form-control" value="{{  old('title', isset($chapter) ? $chapter->title : 'Новая глава') }}" required>
        </div>

        <div class="form-group">
            <label for="text_file">Загрузить текстовый файл (.txt, .docx)</label>
            <input type="file" id="text_file" name="text_file" accept=".txt,.docx" class="form-control">
            <button type="button" id="edit_docx" class="btn btn-warning mt-2" style="display: none;">Редактировать</button>
        </div>

        <div class="form-group" id="text_container">
            <label for="content">Полный текст</label>
            <textarea id="content" name="content" rows="8" class="form-control"  required>{{ old('content', isset($chapter) ? $chapter->content : '') }}</textarea>
        </div>

        <div class="text-right mt-4">
            <button type="submit" class="btn btn-primary" id="submit-chapter">Сохранить</button>
        </div>
    </form>
    @endsection
