<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;

class AdminController extends Controller
{
    public function dashboard()
{
    return view('admin.dashboard');
}

// === КАТЕГОРИИ ===
public function manageCategories()
{
    $categories = Category::all();
    return view('admin.categories.index', compact('categories'));
}

public function storeCategory(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
    ]);

    Category::create(['name' => $request->name]);

    return redirect()->route('admin.categories')->with('success', 'Категория добавлена!');
}

public function deleteCategory($id)
{
    Category::destroy($id);
    return redirect()->route('admin.categories')->with('success', 'Категория удалена!');
}

// === ЖАНРЫ ===
public function manageGenres()
{
    $genres = Genre::all();
    return view('admin.genres.index', compact('genres'));
}

public function storeGenre(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:genres,name',
    ]);

    Genre::create(['name' => $request->name]);

    return redirect()->route('admin.genres')->with('success', 'Жанр добавлен!');
}

public function deleteGenre($id)
{
    Genre::destroy($id);
    return redirect()->route('admin.genres')->with('success', 'Жанр удалён!');
}

// === ПОЛЬЗОВАТЕЛИ ===
public function manageUsers()
{
    $users = User::all();
    return view('admin.users', compact('users'));
}

public function searchUsers(Request $request)
{
    $query = $request->input('email');

    $users = User::where('email', 'LIKE', "%{$query}%")->get();

    return view('admin.users', compact('users'));
}



public function blockUser($id, Request $request)
{
    $user = User::findOrFail($id);
    
    // Если пользователь временно заблокирован
    if ($request->has('blocked_until')) {
        $user->is_blocked = true;
        $user->blocked_until = $request->blocked_until;
    } else {
        // Если пользователь заблокирован навсегда
        $user->is_blocked = true;
        $user->blocked_until = null; // Убираем временную блокировку
    }

    $user->save();

    return redirect()->route('admin.users')->with('success', 'Пользователь заблокирован.');
}

public function unblockUser($id)
{
    $user = User::findOrFail($id);
    $user->is_blocked = false;
    $user->blocked_until = null;
    $user->save();

    return redirect()->route('admin.users')->with('success', 'Пользователь разблокирован.');
}




}
