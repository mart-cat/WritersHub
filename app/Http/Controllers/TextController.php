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
        $query = Text::with('categories');

        // Фильтр по жанру
        if ($request->has('genre')) {
            $query->where('genre_id', $request->genre);
        }

        // Фильтр по категории
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $texts = $query->paginate(10);
        return view('texts.index', compact('texts'));
    }

    // Просмотр конкретного текста
    public function show($id)
    {
        $text = Text::with(['user', 'genre', 'categories', 'statistics'])->findOrFail($id);
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
            'genre_id' => 'required|exists:genres,id',
            'tags' => 'nullable|string',
            'status' => 'required|string',
            'size' => 'required|string',
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
        $text->genre_id = $request->genre_id;

        $text->tags = $tags;
        $text->status = $request->status;
        $text->size = $request->size;
        $text->warnings = $request->warnings;
        $text->age_rating = $request->age_rating;
        $text->dedication = $request->dedication;
        $text->publication_permission = $request->publication_permission;
        $text->user_id = $request->user_id;
        $text->save();
        $text->refresh();
        $text->categories()->sync($request->input('category_id'));
        return redirect()->route('texts.all.chapters', ['text' => $text->id]);
    }


    // Страница редактирования текста

    public function editHeader(Text $text)
    {
        $text->load('categories');
        $genres = Genre::all();
        $categories = Category::all();

        return view('texts.edit-header', compact('text', 'genres', 'categories'));
    }

    public function AllChapters(Text $text)
    {
        $previousChapters = $text->chapters()->get();

        return view('texts.all-chapters', compact('text', 'previousChapters'));
    }

    // Обновление текста
    public function update(Request $request, $id)
    {
        $text = Text::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $text->update([
            'title' => $request->title,
            'description' => $request->description,
            'genre_id' => $request->genre_id,
        ]);

        // Сохраняем категории
        $text->categories()->sync($request->input('category_id'));
        return back()->with('success', 'Текст успешно сохранён!');
    }

    // Удаление текста
    public function destroy($id)
    {
        $text = Text::findOrFail($id);
        $text->delete();

        return redirect()->route('texts.index')->with('success', 'Текст успешно удален!');
    }

    public function filter(Request $request)
    {
        $categories = $request->input('category', []);
        $genreId = $request->input('genre');
    
        // Тексты с полным совпадением всех выбранных категорий
        $fullMatchQuery = Text::query();
    
        if ($genreId) {
            $fullMatchQuery->where('genre_id', $genreId);
        }
    
        if ($categories) {
            $fullMatchQuery->whereHas('categories', function ($q) use ($categories) {
                $q->select('category_text.text_id')
                  ->whereIn('categories.id', $categories)
                  ->groupBy('category_text.text_id')
                  ->havingRaw('COUNT(DISTINCT categories.id) = ?', [count($categories)]);
            });
        }
    
        $fullMatches = $fullMatchQuery->get();
    
        // Получаем IDs текстов, которые уже полные совпадения
        $fullMatchIds = $fullMatches->pluck('id')->toArray();
    
        // Теперь частичные совпадения (если текст уже в полном совпадении — пропускаем его)
        $partialMatchQuery = Text::query();
    
        if ($genreId) {
            $partialMatchQuery->where('genre_id', $genreId);
        }
    
        if ($categories) {
            $partialMatchQuery->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('categories.id', $categories);
            });
    
            if (!empty($fullMatchIds)) {
                $partialMatchQuery->whereNotIn('id', $fullMatchIds);
            }
        }
    
        $partialMatches = $partialMatchQuery->get();
    
        // Теперь объединяем полные и частичные
        $texts = $fullMatches->merge($partialMatches);
    
        $genres = Genre::all();
        $categories = Category::all();
    
        return view('texts.index', compact('texts', 'genres', 'categories'));
    }
    
    



}