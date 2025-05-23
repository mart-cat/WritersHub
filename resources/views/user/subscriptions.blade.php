@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-4xl font-semibold mb-6">Подписки</h1>

        @if ($subscriptions->isEmpty())
            <p class="text-lg text-gray-600">Вы еще не на кого не подписаны</p>
        @else
            <div class="space-y-6">
                @foreach ($subscriptions as $subscription)
                <a href="{{ route('user.profile', $subscription->author->id) }}"
                class="text-blue-600 hover:text-blue-800">{{ $subscription->author->name }}</a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
