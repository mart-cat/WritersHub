@extends('layouts.app')

@section('content')
<x-page-header title="{{ $user->name }}"></x-page-header>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Основной контент -->
            <div class="md:col-span-3">
                
                <h1 class="text-4xl mb-6">Профиль автора: {{ $user->name }}</h1>

                @if($user->texts->isNotEmpty())
                    <div class="space-y-6">
                        <h2 class="text-2xl mb-2">Тексты автора</h2>
                        <div class="space-y-4">
                            @foreach($user->texts as $text)
                                @include('components.textCard', ['text' => $text])
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-4">
                        <p class="text-gray-600">Этот автор ещё не написал ни одного текста.</p>
                    </div>
                @endif
            </div>

            <!-- Боковая панель -->
            <div class="md:col-span-1">
                @auth
                    <form action="{{ route('subscriptions.toggle', $user->id) }}" method="POST" class="bg-white border border-yellow-700 rounded p-4">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 rounded text-white font-semibold
                            {{ auth()->user()->subscriptions->where('author_id', $user->id)->count() ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
                            {{ auth()->user()->subscriptions->where('author_id', $user->id)->count() ? 'Отписаться' : 'Подписаться' }}
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
