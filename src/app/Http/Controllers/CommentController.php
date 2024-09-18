<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;


class CommentController extends Controller
{
    public function create(Item $item)
    {
        $comments = $item->comments()->latest()->get();
        $item->load('comments');

        return view('comment', compact('item', 'comments'));
    }

    public function store(CommentRequest $request, Item $item)
    {
        $user_id = Auth::id();

        $comment = Comment::create([
            'user_id' => $user_id,
            'item_id' => $item->id,
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('create.comment', $item->id)->with('create', 'コメントが追加されました。');
    }

    public function adminComment(Item $item)
    {
        $comments = $item->comments()->latest()->get();
        $item->load('comments');

        return view('comment', compact('item', 'comments'));
    }

    public function destroy(Item $item, Comment $comment)
    {
        $user = Auth::user();

        if ($comment->user_id !== $user->id && $user->role !== 1) {
            return redirect()->route('destroy.comment', $item->id)->with('fail', '削除権限がありません。');
        }

        $comment->delete();

        return redirect()->route('create.comment', $item->id)->with('delete', 'コメントが削除されました。');
    }
}
