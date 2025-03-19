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

        if ($request->has('genre')) {
            $query->where('genre_id', $request->genre);
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $texts = $query->paginate(10);
        return view('texts.index', compact('texts'));
    }

    public function show($id)
    {
        $text = Text::with(['user', 'genres', 'categories'])->findOrFail($id);
        $comments = $text->comments()->with('user')->latest()->get();

        $isFavorite = auth()->check()
            ? auth()->user()->favorites()->where('text_id', $id)->exists()
            : false;

        return view('texts.show', compact('text', 'comments', 'isFavorite'));
    }

    public function create()
    {
        $genres = Genre::all();
        $categories = Category::all();
        return view('texts.create', [
            'genres' => $genres,
            'categories' => $categories,
            'text' => new Text()
        ]);
        
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => auth()->id()]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'genre_id' => 'required|exists:genres,id',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|string',
            'size' => 'required|string',
            'warnings' => 'nullable|string',
            'age_rating' => 'required|string',
            'dedication' => 'nullable|string',
            'publication_permission' => 'required|string',
        ]);

        $tags = $request->tags ? json_encode(explode(',', $request->tags)) : json_encode([]);

        $text = new Text();
        $text->title = $request->title;
        $text->description = $request->description;
        $text->genre_id = $request->genre_id;
        $text->category_id = $request->category_id;
        $text->tags = $tags;
        $text->status = $request->status;
        $text->size = $request->size;
        $text->warnings = $request->warnings;
        $text->age_rating = $request->age_rating;
        $text->dedication = $request->dedication;
        $text->publication_permission = $request->publication_permission;
        $text->user_id = $request->user_id;
        $text->save();

        return redirect()->route('texts.index')->with('success', 'Текст успешно создан! Добавьте главы.');
    }

    public function edit($id)
    {
        $text = Text::findOrFail($id);
        $genres = Genre::all();
        $categories = Category::all();

        return view('texts.edit', compact('text', 'genres', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $text = Text::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $text->update($request->all());

        return redirect()->route('texts.show', $text->id)->with('success', 'Текст успешно обновлен!');
    }

    public function destroy($id)
    {
        $text = Text::findOrFail($id);
        $text->delete();

        return redirect()->route('texts.index')->with('success', 'Текст успешно удален!');
    }
}
