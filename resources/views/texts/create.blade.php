@extends('layouts.app')

@section('title', isset($text) ? 'Редактирование текста' : 'Создание нового текста')

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ isset($text) ? 'Редактирование текста' : 'Создание нового текста' }}</h1>

        <div class="card p-3">
            <ul class="nav nav-tabs mb-4" id="formTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-header" href="#" onclick="switchTab('header')">Шапка</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-chapters" href="#" onclick="switchTab('chapters')">Главы</a>
                </li>
            </ul>

            {{-- Форма --}}
            <form action="{{ isset($text) ? route('texts.update', $text->id) : route('texts.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($text))
                    @method('PUT') {{-- Устанавливаем метод PUT для редактирования --}}
                    <input type="hidden" name="text_id" value="{{ $text->id }}">
                @else
                    <input type="hidden" name="text_id" value="{{ old('text_id', $text_id) }}">
                @endif

                {{-- Вкладка "Шапка" --}}
                @include('texts.partials.form-header')
                
                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-primary">{{ isset($text) ? 'Обновить' : 'Сохранить' }}</button>
                </div>
                </div>
            </form>

            {{-- Вкладка "Главы" --}}
            @include('texts.partials.form-chapters')
        </div>
    </div>

    {{-- JS --}}
    @include('texts.partials.form-scripts')
@endsection
