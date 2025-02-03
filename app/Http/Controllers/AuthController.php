<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;


class AuthController extends Controller
{
    // Показать форму регистрации
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // Показать форму входа
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Обработка входа

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Auth::attempt($request->only('email', 'password'))) {
        return Response::json(['error' => 'Invalid credentials'], 401);
    }

    // Генерируем код 2FA
    $user->two_factor_code = mt_rand(100000, 999999);
    $user->two_factor_expires_at = Carbon::now()->addMinutes(10);
    $user->save();

    // Отправляем код на e-mail
    Mail::raw("Ваш код подтверждения: {$user->two_factor_code}", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Код подтверждения 2FA');
    });

    // Сохраняем в сессии email пользователя (чтобы потом найти его)
    Session::put('2fa_email', $user->email);

    return Response::json(['success' => '2FA code sent'], 200);
}

public function verifyTwoFactorAjax(Request $request)
{
    $request->validate([
        'two_factor_code' => 'required|numeric',
    ]);

    // Получаем e-mail из сессии
    $email = Session::get('2fa_email');
    $user = User::where('email', $email)
                ->where('two_factor_code', $request->two_factor_code)
                ->where('two_factor_expires_at', '>', Carbon::now())
                ->first();

    if (!$user) {
        return Response::json(['error' => 'Invalid or expired code'], 401);
    }

    // Очищаем код 2FA после успешного входа
    $user->two_factor_code = null;
    $user->two_factor_expires_at = null;
    $user->save();

    Auth::login($user);
    Session::forget('2fa_email');

    return Response::json(['success' => 'Authenticated'], 200);
}


    // Обработка выхода
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'You have logged out.');
    }
}
