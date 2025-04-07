<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
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
    public function store(Request $request, $text_id)
    {   
    
    // Валидация данных
    $request->validate([
        'content' => 'required|string',  
    ]);

    

    // Создание новой главы
    $chapter = new Chapter();
    $chapter->text_id = $text_id;  // Используем переданный text_id из URL
    $chapter->title = 'Заглушка';  // Титул главы
    $chapter->content = $request->input('content');  // Сохраняем содержимое

    // Расчет символов и страниц
    $chapter->char_count = strlen($chapter->content);  // Количество символов
    $chapter->page_count = ceil($chapter->char_count / 2500);  // Пример расчета количества страниц

    // Сохраняем главу
    $chapter->save();
    // Возврат ответа с успехом
    return response()->json([
        'success' => true,
        'message' => 'Глава успешно сохранена!',
        'chapter' => $chapter
    ]);
    
}

    
}
