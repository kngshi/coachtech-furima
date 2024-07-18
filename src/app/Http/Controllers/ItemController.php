<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // トップページの表示
    public function index(Request $request)
    {
        $items = Item::all();

        return view('index', compact('items'));
    }

    //商品詳細ページの表示
    public function itemDetail(Item $item)
    {
        return view('item', compact('item'));
    }

    // 商品詳細ページから、/purchase/{item}にデータ送信
    public function postDetail(Request $request)
    {
        $item = Item::findOrFail($request->item_id);

        return redirect()->route('item.purchase', ['item' => $request->item_id]);
    }

    // 購入ページの表示
    public function purchaseInformation(Item $item)
    {
        return view('purchase', compact('item'));
    }

    //  購入確定ボタン
    public function purchaseItem(Request $request, Item $item)
    {
        // ログインユーザーのIDを取得
        $user_id = Auth::id();

        // 購入情報を保存
        $soldItem = SoldItem::create([
            'user_id' => $user_id,
            'item_id' => $item->id,
        ]);

        // 購入完了ページにリダイレクト
        return redirect()->route('purchase.complete', ['item' => $item->id]);
    }

     public function purchaseComplete(Item $item)
    {
        return view('complete', compact('item'));
    }


    public function editAddress(Item $item)
    {

        return view('address');
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
