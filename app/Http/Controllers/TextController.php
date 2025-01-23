<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Text;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function index(Request $request)
    {
        $query = Text::query();

        // Фильтр по жанру
        if ($request->has('genre')) {
            $query->where('genre_id', $request->genre);
        }

        // Фильтр по категории
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $texts = $query->paginate(10);
        return view('texts.index', compact('texts'));
    }

    // Просмотр конкретного текста
    public function show($id)
    {
        $text = Text::with(['user', 'genre', 'category', 'statistics'])->findOrFail($id);
        $comments = $text->comments()->with('user')->latest()->get();

        $isFavorite = auth()->check()
            ? auth()->user()->favorites()->where('text_id', $id)->exists()
            : false;

        return view('texts.show', compact('text', 'comments', 'isFavorite'));
    }

    // Страница создания текста
    public function create()
    {
        $genres = Genre::all();
        $categories = Category::all();
        return view('texts.create', compact('genres', 'categories'));
    }

    // Сохранение нового текста
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
            'category_id' => 'required|exists:categories,id',
            'size' => 'required|in:mini,standard,maxi',
        ]);

        $text = new Text($request->all());
        $text->user_id = auth()->id(); // Связываем текст с текущим пользователем
        $text->char_count = strlen($request->content);
        $text->chapter_count = substr_count($request->content, '###'); // Считаем главы через разделитель
        $text->save();

        return redirect()->route('texts.show', $text->id)->with('success', 'Текст успешно создан!');
    }

    // Страница редактирования текста
    public function edit($id)
    {
        $text = Text::findOrFail($id);
        $genres = Genre::all();
        $categories = Category::all();

        return view('texts.edit', compact('text', 'genres', 'categories'));
    }

    // Обновление текста
    public function update(Request $request, $id)
    {
        $text = Text::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $text->update($request->all());
        $text->char_count = strlen($request->content);
        $text->chapter_count = substr_count($request->content, '###');
        $text->save();

        return redirect()->route('texts.show', $text->id)->with('success', 'Текст успешно обновлен!');
    }

    // Удаление текста
    public function destroy($id)
    {
        $text = Text::findOrFail($id);
        $text->delete();

        return redirect()->route('texts.index')->with('success', 'Текст успешно удален!');
    }
}
