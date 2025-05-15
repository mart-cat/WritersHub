<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        $categories = Category::all();
        $texts = Text::with(['genre'], ['categories'])->take(10)->get(); // Берем последние 10 текстов
        $texts->each(function ($text) {
            $text->short_title = Str::limit($text->title, 30);
            $text->short_description = Str::limit($text->description, 100);
        });
        return view('home.index', compact('texts','genres', 'categories'));
    }

    // О проекте
    public function about()
    {
        return view('home.about');
    }

    // Контакты
    public function contact()
    {
        return view('home.contact');
    }
}
