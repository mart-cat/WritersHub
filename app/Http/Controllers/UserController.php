<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Главная страница личного кабинета
    public function dashboard()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }

    // Профиль пользователя
    public function profile($id)
    {
        $user = User::findOrFail($id);
        return view('user.profile', compact('user'));
        
    }

    // Метод для обновления основных данных пользователя
    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ], [
        'name.required'  => 'Пожалуйста, укажите имя.',
        'name.string'    => 'Имя должно быть строкой.',
        'name.max'       => 'Имя не должно превышать 255 символов.',

        'email.required' => 'Пожалуйста, укажите email.',
        'email.email'    => 'Введите корректный email-адрес.',
        'email.unique'   => 'Такой email уже используется другим пользователем.',
    ]);

    $user->name  = $request->name;
    $user->email = $request->email;
    $user->save();

    return redirect()
        ->route('user.profile.edit', ['id' => $user->id])
        ->with('success', 'Профиль успешно обновлён.');
}


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
        
    }


}
