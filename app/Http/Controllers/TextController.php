<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Text;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Genre;

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
        $comments = Comment::with(['user', 'replies.user', 'parent.user'])
            ->where('text_id', $text->id) // Фильтр по text_id
            ->whereNull('parent_id') // Только корневые комментарии
            ->orderBy('created_at', 'asc')
            ->get();
        $comments_count = Comment::with(['user', 'replies.user', 'parent.user'])
            ->orderBy('created_at', 'asc')
            ->where('text_id', $text->id) // Фильтр по text_id
            ->get()
            ->count();

        $isFavorite = auth()->check()
            ? auth()->user()->favorites()->where('text_id', $id)->exists()
            : false;

        return view('texts.show', compact('text', 'comments', 'isFavorite', 'comments_count'));
    }

    // Страница создания текста
    public function create()
    {
        $genres = Genre::all();
        $categories = Category::all();
        return view('texts.create', compact('genres', 'categories'));
    }

    public function store(Request $request)
    {

        $request->merge(['user_id' => auth()->id()]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'content' => 'nullable|string',
            'genre_id' => 'required|exists:genres,id',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'status' => 'required|string',
            'size' => 'required|string',
            'char_count' => 'nullable|integer',
            'chapter_count' => 'nullable|integer',
            'warnings' => 'nullable|string',
            'age_rating' => 'required|string',
            'dedication' => 'nullable|string',
            'publication_permission' => 'required|string',
            'text_file' => 'nullable|file|mimes:txt', // Ограничиваем только текстовыми файлами
        ]);

        $content = $request->input('content', ''); // Используем пустую строку по умолчанию

        if ($request->hasFile('text_file')) {
            $file = $request->file('text_file');
            $fileContent = file_get_contents($file->getRealPath());
            $content .= "\n\n" . $fileContent;
        }

        $tags = $request->tags ? json_encode(explode(',', $request->tags)) : json_encode([]);

        $text = new Text();
        $text->title = $request->title;
        $text->description = $request->description;
        $text->content = $content;
        $text->genre_id = $request->genre_id;
        $text->category_id = $request->category_id;
        $text->tags = $tags;
        $text->status = $request->status;
        $text->size = $request->size;
        $text->char_count = $request->char_count;
        $text->chapter_count = $request->chapter_count;
        $text->warnings = $request->warnings;
        $text->age_rating = $request->age_rating;
        $text->dedication = $request->dedication;
        $text->publication_permission = $request->publication_permission;
        $text->user_id = $request->user_id;
        $text->save();

        return redirect()->route('texts.index')->with('success', 'Текст успешно сохранён!');
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

    public function parseFile(Request $request)
    {
        try {
            // Логика обработки файла
            $file = $request->file('text_file');
            
            // Обработка файла, например, с использованием библиотеки для работы с .docx
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

    }
}