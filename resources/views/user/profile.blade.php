@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Основной контент -->
        <div class="col-md-8">
            <h1>Профиль автора: {{ $user->name }}</h1>
            
            <!-- Если есть тексты у автора -->
            @if($user->texts->isNotEmpty())
                <div class="section">
                    <h3>Тексты автора</h3>
                    <ul>
                        @foreach($user->texts as $text)
                            @include('components.textCard', ['text' => $text])
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="section">
                    <p>Этот автор еще не написал ни одного текста.</p>
                </div>
            @endif
        </div>

        <!-- Боковая панель -->
        <div class="col-md-4">
            <ul class="list-group">
                @auth
                    <li class="list-group-item">
                        <form action="{{ route('subscriptions.toggle', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ auth()->user()->subscriptions->contains($user->id) ? 'Отписаться' : 'Подписаться' }}
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</div>
@endsection