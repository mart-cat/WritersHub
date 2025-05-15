<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Text;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function show($id)
    {
        // Ищем главу по ID
        $chapter = Chapter::find($id);

        // Если глава найдена, возвращаем данные в формате JSON
        if ($chapter) {
            return response()->json([
                'title' => $chapter->title,
                'content' => $chapter->content,
            ]);
        }

        return response()->json(['error' => 'Chapter not found'], 404);
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

    public function save($text_id, $chapter_id = null)
{
    $chapter_id = request()->query('id');
    $text = Text::findOrFail($text_id);
    $chapter = null;

    if ($chapter_id) {
        $chapter = Chapter::where('id', $chapter_id)
                          ->where('text_id', $text_id) // <-- Проверка, что глава принадлежит этому тексту
                          ->firstOrFail(); 
    }
   

    return view('texts.edit-chapters', compact('text', 'chapter'));
}



    public function store(Request $request, $text_id, $chapter_id = null)
    {   
    // Валидация данных
    $request->validate([
        'content' => 'required|string',  
        'title' => 'required|string', 
    ]);
    $chapter_id = request()->query('id');
    if ($chapter_id) {
        $chapter = Chapter::findOrFail($chapter_id);
        $chapter->update($request->only(['title', 'content']));
        return back();

    } else {
    // Создание новой главы
    $chapter = new Chapter();
    $chapter->text_id = $text_id;  // Используем переданный text_id из URL
    $chapter->title = $request->title;  // Титул главы
    $chapter->content = $request->input('content');  // Сохраняем содержимое

    // Расчет символов и страниц
    $chapter->char_count = strlen($chapter->content);
    $chapter->page_count = ceil($chapter->char_count / 2500); 

    // Сохраняем главу
    $chapter->save();
    return redirect()->route('texts.all.chapters', ['text' => $text_id]);
    }
    
    
}

    
}
