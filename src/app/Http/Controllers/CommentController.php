<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function createComment(Item $item)
    {
        $comments = $item->comments()->latest()->get();
        $item->load('comments');

        return view('comment', compact('item', 'comments'));
    }

    public function storeComment(Request $request, Item $item)
    {
        $user_id = Auth::id();

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => $user_id,
            'item_id' => $item->id,
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('create.comment', $item->id)->with('create', 'コメントが追加されました。');
    }

    public function destroyComment(Item $item, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return redirect()->route('destroy.comment', $item->id)->with('fail', '削除権限がありません。');
        }

        $comment->delete();

        return redirect()->route('create.comment', $item->id)->with('delete', 'コメントが削除されました。');
    }
}