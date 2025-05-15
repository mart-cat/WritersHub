
@extends('layouts.app')

@section('title', 'Редактирование шапки')

@section('content')
<div class="container">
    <h1 class="mb-4">Редактирование шапки</h1>

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

        <form action="{{ route('texts.update', $text->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="text_id" value="{{ $text->id }}">

            @include('texts.partials.form-header')

            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary">Обновить</button>
            </div>
        </form>
    </div>
</div>
@endsection
