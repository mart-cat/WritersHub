@extends('layouts.app')

@section('title', 'Список текстов')

@section('content')
<div class="container">
    <h1 class="mb-4">Все тексты</h1>
    
    <div class="text-list">
        @foreach ($texts as $text)
            
                @include('components.textCard', ['text' => $text])
            
        @endforeach
    </div>

    {{-- Пагинация --}}
    @include('components.pagination', ['paginator' => $texts])
</div>
@endsection
