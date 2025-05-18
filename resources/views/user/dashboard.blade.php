@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Основной контент -->
            <div class="md:col-span-3">
                <h1 class="text-4xl   mb-6 mt-10">Добро пожаловать, {{ auth()->user()->name }}</h1>

                {{-- Избранное --}}
                <div class="mb-10">
                    <h2 class="text-2xl   mb-4">Ваши избранные тексты</h2>
                    @if(auth()->user()->favorites->isNotEmpty())
                        <ul class="list-disc list-inside space-y-2">
                            @foreach(auth()->user()->favorites as $favorite)
                                <li>
                                    <a href="{{ route('texts.show', $favorite->id) }}" class="underline hover:no-underline">
                                        {{ $favorite->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('user.favorites') }}"
                           class="inline-block mt-4 text-sm text-yellow-800 underline hover:text-yellow-900">
                            Посмотреть все избранные →
                        </a>
                    @else
                        <p class="text-gray-600">У вас нет избранных текстов.</p>
                    @endif
                </div>

                {{-- Подписки --}}
                <div class="mb-10">
                    <h2 class="text-2xl   mb-4">Ваши подписки</h2>
                    @if(auth()->user()->subscriptions->isNotEmpty())
                        <ul class="list-disc list-inside space-y-2">
                            @foreach(auth()->user()->subscriptions as $subscription)
                                <li>
                                    <a href="{{ route('user.profile', $subscription->author_id) }}"
                                       class="underline hover:no-underline">
                                        {{ $subscription->author->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600">Вы ещё не подписаны на других пользователей.</p>
                    @endif
                </div>

                {{-- Мои тексты --}}
                <div class="mb-10">
                    <h2 class="text-2xl   mb-4">Мои тексты</h2>
                    @if(auth()->user()->texts->isNotEmpty())
                        <div class="space-y-6">
                            @foreach(auth()->user()->texts as $text)
                                @include('components.textCard', ['text' => $text])
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">
                            Вы ещё не написали ни одного текста.
                            <a href="{{ route('texts.create') }}" class="underline hover:no-underline text-yellow-800">
                                Напишите свой первый текст →
                            </a>
                        </p>
                    @endif
                </div>
            </div>

            <!-- Боковая панель -->
            <div class="md:col-span-1 mt-10">
                <div class=" border border-yellow-700 rounded p-4 space-y-3">
                    <a href="{{ route('user.favorites') }}" class="block hover:underline">Избранные тексты</a>
                    <a href="{{ route('user.subscriptions') }}" class="block hover:underline">Ваши подписки</a>
                    <a href="{{ route('user.profile.edit', auth()->id()) }}" class="block hover:underline">Редактировать профиль</a>
                    <a href="{{ route('texts.create') }}" class="block hover:underline">Создать текст</a>
                </div>
            </div>
        </div>
    </div>
@endsection
