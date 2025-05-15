@extends('layouts.app')

@section('title', 'Просмотр глав')

@section('content')
<div class="container">
    <h1 class="mb-4">Просмотр глав</h1>

    <div class="card p-3">
        {{-- Вкладки --}}
        <ul class="nav nav-tabs mb-4" id="formTabs">
            <li class="nav-item">
                <a class="nav-link" id="tab-header" href="{{ route('texts.edit', $text->id) }}">Шапка</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="tab-chapters" href="{{ route('texts.all.chapters', $text->id) }}">Главы</a>
            </li>
        </ul>

        @include('texts.partials.form-chapters')
    </div>
</div>

@include('texts.partials.form-scripts')
@endsection
