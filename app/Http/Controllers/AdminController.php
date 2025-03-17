<?php

namespace App\Http\Controllers;

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
}
