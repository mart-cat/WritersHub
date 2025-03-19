<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
{
    // Получаем все тексты, которые в избранном у текущего пользователя
    $favorites = Favorite::where('user_id', auth()->id())->get();
    $texts = Text::whereIn('id', $favorites->pluck('text_id'))->get();

    // Для каждого текста определяем, находится ли он в избранном
    $textsWithFavorites = $texts->map(function ($text) {
        $text->isFavorite = Favorite::where('user_id', auth()->id())->where('text_id', $text->id)->exists();
        return $text;
    });

    // Передаем переменные в представление
    return view('user.favorites', ['textsWithFavorites' => $textsWithFavorites, 'favorites' => $favorites, 'texts' => $texts]);
}



    public function store($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $text = Text::findOrFail($id);
        $favorite = new Favorite();
        $favorite->user_id = auth()->id();
        $favorite->text_id = $text->id;
        $favorite->save();

        return redirect()->back()->with('success', 'Текст добавлен в избранное');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorite = Favorite::where('text_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Текст удален из избранного');
        }

        return redirect()->back()->with('error', 'Ошибка удаления');
    }

    public function toggle($id)
    {
        
        // Если пользователь не авторизован, перенаправляем на страницу логина
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorite = Favorite::where('text_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Текст удален из избранного');
        }

        $favorite = new Favorite();
        $favorite->user_id = auth()->id();
        $favorite->text_id = $id;
        $favorite->save();

        return redirect()->back()->with('success', 'Текст добавлен в избранное');
    }
}
