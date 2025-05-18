@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-20 ">

        <x-back page="Мои избранные тексты" />

        @if ($texts->isEmpty())
            <p class="text-lg text-gray-600">У вас нет избранных текстов.</p>
        @else
            <div class="space-y-6">
                @foreach ($texts as $text)
                @include('components.textCard', ['text' => $text])
                @endforeach
            </div>
        @endif
    </div>
@endsection
