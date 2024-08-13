<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\SoldItem;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::id();

        $items = Item::all();

        $likedItems = Like::where('user_id', $user_id)->with('item')->get()->pluck('item');

        $categories = Category::all();

        return view('index', compact('items', 'likedItems', 'categories'));
    }

    public function itemDetail(Item $item)
    {
        $item->load('categories', 'condition');
        return view('item', compact('item'));
    }

    public function postDetail(Request $request)
    {
        $item = Item::findOrFail($request->item_id);

        return redirect()->route('item.purchase', ['item' => $request->item_id]);
    }

    public function purchaseInformation(Item $item)
    {
        return view('purchase', compact('item'));
    }

    public function purchaseItem(Request $request, Item $item)
    {
        $user_id = Auth::id();

        $soldItem = SoldItem::create([
            'user_id' => $user_id,
            'item_id' => $item->id,
        ]);

        return redirect()->route('purchase.complete', ['item' => $item->id]);
    }

    public function purchaseComplete(Item $item)
    {
        return view('complete', compact('item'));
    }

    public function createItem()
    {
        $user_id = Auth::id();
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell', compact('user_id','categories','conditions'));
    }

    public function storeItem(Request $request)
    {
        $user_id = Auth::id();

        $validatedData = $request->validate([
            'name' => 'required|string|max:191',
            'brand' => 'required|string|max:191',
            'price' => 'required|integer',
            'description' => 'required|string|max:400',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required',
            'condition_id' => 'required|integer',
            // category_idを一旦抜いた状態で実装（仕様の確認中）
        ]);

        if ($request->hasFile('img_url')) {
            $image = $request->file('img_url');
            $imagePath = $image->store('items', 'public');
            $imageUrl = Storage::url($imagePath);
        } else {
            $imageUrl = null;
        }

        $item = Item::create([
            'name' => $validatedData['name'],
            'brand' => $validatedData['brand'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'img_url' => $imageUrl,
            'user_id' => $user_id,
            'condition_id' => $validatedData['condition_id'],
        ]);

        // カテゴリの関連付け
        if ($request->filled('categories')) {
        $item->categories()->sync($request->categories);
    }

        return redirect()->route('mypage', compact('user_id'))
            ->with('success', '商品を出品しました。');
    }
}
