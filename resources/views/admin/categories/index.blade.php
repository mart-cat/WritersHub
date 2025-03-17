@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Категории</h1>

    <!-- Форма добавления категории -->
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Название категории" required>
        <button type="submit">Добавить</button>
    </form>

    <!-- Список категорий -->
    <ul>
        @foreach($categories as $category)
            <li>
                {{ $category->name }}
                <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
