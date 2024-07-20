<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        // ログインユーザーのIDを取得
        $user_id = Auth::id();
        
        return view('sell', compact('user_id'));
    }

    public function store(Request $request)
    {
        // ログインユーザーのIDを取得
        $user_id = Auth::id();

        $validatedData = $request->validate([
            'name' => 'required|string|max:191',
            'price' => 'required|integer',
            'description' => 'required|string|max:400',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required',
            'condition_id' => 'required|integer',
        ]);

        // 画像のアップロード処理
        if ($request->hasFile('img_url')) {
            $image = $request->file('img_url');
            $imagePath = $image->store('items', 'public');
            $imageUrl = Storage::url($imagePath);
        } else {
            $imageUrl = null;
        }

        // 商品情報の保存
        $item = Item::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'img_url' => $imageUrl,
            'user_id' => $user_id,
            'condition_id' => $validatedData['condition_id'],
        ]);

        // カテゴリーの紐付け
        if ($request->has('category_id')) {
            $item->categories()->sync([$request->input('category_id')]);
        }

        return redirect()->route('mypage', compact('user_id'))
            ->with('success', '商品を出品しました。');
    }

}
