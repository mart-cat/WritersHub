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

    // Обновление профиля
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Проверка, что пользователь редактирует свой профиль
        if (Auth::id() !== $user->id) {
            return redirect()->back()->with('error', 'Вы не можете редактировать этот профиль.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('user.profile', $user->id)->with('success', 'Профиль успешно обновлен.');
    }
}
