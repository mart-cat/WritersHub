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
}
