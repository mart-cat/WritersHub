@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <x-back page="Управление пользователями" />

    {{-- Успешное сообщение --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Поиск пользователя --}}
    <form action="{{ route('admin.users.search') }}" method="GET" class="mb-8 flex flex-col md:flex-row gap-4">
        <input type="text" name="email" value="{{ old('email') }}" placeholder="Введите email"
               class="w-full md:w-1/2 px-4 py-2 rounded border border-borderGold">
        <button type="submit"
                class="bg-action text-white px-6 py-2 rounded hover:bg-actionHover transition">Поиск</button>
    </form>

    {{-- Таблица пользователей --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border border-borderGold  rounded overflow-hidden">
            <thead>
                <tr class=" text-black">
                    <th class="px-4 py-3 border border-borderGold">Имя</th>
                    <th class="px-4 py-3 border border-borderGold">Email</th>
                    <th class="px-4 py-3 border border-borderGold">Статус</th>
                    <th class="px-4 py-3 border border-borderGold">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr id="user-row-{{ $user->id }}" class="border-t border-borderGold">
                        <td class="px-4 py-3"><a href="{{ route('user.profile', $user->id) }}" class="hover:underline">{{ $user->name }}</a></td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->is_blocked)
                                @if($user->blocked_until && $user->blocked_until > now())
                                    Заблокирован до {{ $user->blocked_until }}
                                @else
                                    Заблокирован навсегда
                                @endif
                            @else
                                Активен
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if(!$user->is_blocked)
                                <button onclick="toggleBlockForm({{ $user->id }})"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                                    Заблокировать
                                </button>
                            @else
                                <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                                        Разблокировать
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>

                    {{-- Форма блокировки --}}
                    <tr id="block-form-row-{{ $user->id }}" style="display: none;" class="bg-[#fff8e6]">
                        <td colspan="4" class="px-4 py-4">
                            <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="space-y-3">
                                @csrf

                                <label class="block text-sm font-medium">Причина:</label>
                                <select name="reason" required class="w-full border border-borderGold rounded px-3 py-2">
                                    <option value="">Выберите причину</option>
                                    <option value="Спам">Спам</option>
                                    <option value="Нарушение правил">Нарушение правил</option>
                                    <option value="Оскорбления">Оскорбления</option>
                                    <option value="Другое">Другое</option>
                                </select>

                                <label class="block text-sm font-medium">Комментарий:</label>
                                <textarea name="comment" rows="2"
                                          class="w-full border border-borderGold rounded px-3 py-2 resize-none"
                                          placeholder="Комментарий (необязательно)"></textarea>

                                <label class="block text-sm font-medium">Время блокировки:</label>
                                <input type="datetime-local" name="blocked_until"
                                       class="w-full border border-borderGold rounded px-3 py-2 bg-white">

                                <div class="flex gap-2 justify-end">
                                    <button type="submit"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm">
                                        Временно
                                    </button>
                                    <button type="submit" name="permanent" value="1"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                                        Навсегда
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Скрипт JS --}}
<script>
    function toggleBlockForm(userId) {
        const row = document.getElementById(`block-form-row-${userId}`);
        if (row.style.display === "none" || row.style.display === "") {
            row.style.display = "table-row";
            document.addEventListener('click', closeOnClickOutside);
        } else {
            row.style.display = "none";
            document.removeEventListener('click', closeOnClickOutside);
        }

        function closeOnClickOutside(e) {
            const targetRow = document.getElementById(`user-row-${userId}`);
            const formRow = document.getElementById(`block-form-row-${userId}`);
            if (!targetRow.contains(e.target) && !formRow.contains(e.target)) {
                formRow.style.display = "none";
                document.removeEventListener('click', closeOnClickOutside);
            }
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^=block-form-row-]').forEach(row => {
                row.style.display = 'none';
            });
        }
    });
</script>
@endsection
