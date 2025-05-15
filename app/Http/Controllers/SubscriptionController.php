<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // поправил здесь (раньше было с ошибкой!)
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        // Получаем все подписки текущего пользователя вместе с данными авторов
        $subscriptions = Subscription::with('author')
            ->where('user_id', auth()->id())
            ->get();

        return view('user.subscriptions', ['subscriptions' => $subscriptions]);
    }

    public function store($authorId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Проверяем, нет ли уже такой подписки
        $exists = Subscription::where('user_id', auth()->id())
            ->where('author_id', $authorId)
            ->exists();

        if (!$exists) {
            Subscription::create([
                'user_id' => auth()->id(),
                'author_id' => $authorId,
            ]);
        }

        return redirect()->back()->with('success', 'Вы подписались на пользователя.');
    }

    public function destroy($authorId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $subscription = Subscription::where('user_id', auth()->id())
            ->where('author_id', $authorId)
            ->first();

        if ($subscription) {
            $subscription->delete();
            return redirect()->back()->with('success', 'Подписка удалена.');
        }

        return redirect()->back()->with('error', 'Подписка не найдена.');
    }

    public function toggle($authorId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $subscription = Subscription::where('user_id', auth()->id())
            ->where('author_id', $authorId)
            ->first();

        if ($subscription) {
            $subscription->delete();
            return redirect()->back()->with('success', 'Подписка удалена.');
        }

        Subscription::create([
            'user_id' => auth()->id(),
            'author_id' => $authorId,
        ]);

        return redirect()->back()->with('success', 'Вы подписались на пользователя.');
    }
}
