<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $text = Text::findOrFail($id);

        Comment::create([
            'text_id' => $text->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()->with('success', 'Комментарий добавлен!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Вы не можете удалить этот комментарий.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий удален.');
    }
}
