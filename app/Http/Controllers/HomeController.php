<?php

namespace App\Http\Controllers;

use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $texts = Text::latest()->take(10)->get(); // Берем последние 10 текстов
        $texts->each(function ($text) {
            $text->short_title = Str::limit($text->title, 30);
            $text->short_description = Str::limit($text->description, 100);
        });
        return view('home.index', compact('texts'));
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
