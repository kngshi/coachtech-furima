<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        $items = Item::all();

        return view('index');
    }

    public function create()
    {
        return view('sell');
    }

    public function store(Request $request)
    {
        // ログインユーザーのIDを取得
        $userId = Auth::id();

        $img_url = 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg';

        $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'img_url' => 'required',
            'user_id' => 'required',
            'condition_id' => 'required',
        ]);

        $itemData = [
            'user_id' => $userId,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'img_url' => $img_url,
            'user_id' => $userId,
            'condition_id' => $request->input('condition_id'),
        ];

        $sell = Item::create($itemData);

        return view('sell', compact('sell'));
    }

}
