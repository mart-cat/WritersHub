@extends('layouts.app')

@section('title', 'Создание нового текста')

@section('content')
<div class="container">
    <h1 class="mb-4">Создание нового текста</h1>

    <div class="card p-3">
        <form action="{{ route('texts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Вкладка "Шапка" --}}
            @include('texts.partials.form-header')

            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
@endsection
