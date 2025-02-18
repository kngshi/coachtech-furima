<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request, Item $item)
    {
        $user_id = Auth::id();
        $item_id = $item->id;

        $favoriteData = [
            'user_id' => $user_id,
            'item_id' => $item_id,
        ];

        $favorite = Like::create($favoriteData);

        if ($favorite) {
            return redirect()->route('item.detail', ['item' => $item->id])->with('create', 'お気に入りに追加しました');
        } else {
            return redirect()->back()->with('fail', 'お気に入り追加に失敗しました。');
        }
    }

    public function unlike(Request $request, Item $item)
    {
        $user_id = Auth::id();
        $item_id = $item->id;

        $deleted = Like::where('user_id', $user_id)
                        ->where('item_id', $item_id)
                        ->delete();

        if ($deleted) {
            return redirect()->route('item.detail', ['item' => $item->id])->with('delete', 'お気に入りを削除しました');
        } else {
            return redirect()->back()->with('fail', 'お気に入りの削除に失敗しました。');
        }
    }
}
