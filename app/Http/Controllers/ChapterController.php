<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Text;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function create($textId)
    {
        $text = Text::findOrFail($textId);
        return view('chapters.create', compact('text'));
    }

    public function store(Request $request, $textId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $chapter = new Chapter();
        $chapter->text_id = $textId;
        $chapter->title = $request->title;
        $chapter->content = $request->content;
        $chapter->char_count = strlen($request->content);
        $chapter->save();

        return redirect()->route('texts.show', $textId)->with('success', 'Глава успешно добавлена!');
    }

    public function destroy($id)
    {
        $chapter = Chapter::findOrFail($id);
        $textId = $chapter->text_id;
        $chapter->delete();

        return redirect()->route('texts.show', $textId)->with('success', 'Глава удалена!');
    }
}
