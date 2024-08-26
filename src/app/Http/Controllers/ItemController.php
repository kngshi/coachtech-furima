<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\SoldItem;
use App\Models\Like;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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

        return redirect()->route('purchase.item', ['item' => $request->item_id]);
    }

    public function purchaseInformation(Item $item)
    {
        $user_id = Auth::id();

    // ユーザーが選択した支払い方法を取得
    $soldItem = SoldItem::where('user_id', $user_id)
                        ->where('item_id', $item->id)
                        ->first();

        // 支払い方法が設定されていない場合はデフォルト値を設定
        if (is_null($soldItem) || is_null($soldItem->payment_method_id)) {
            $paymentMethod = PaymentMethod::find(1); // クレジットカードをデフォルトに設定
        } else {
            $paymentMethod = PaymentMethod::find($soldItem->payment_method_id);
        }

        return view('purchase', compact('item', 'paymentMethod'));
    }

    public function purchaseItem(Request $request, Item $item)
    {
        $user = Auth::user();

        $profile = $user->profile;

        if (is_null($profile)) {
            return redirect()->back()->with('error', '配送先を設定して下さい。');
        }

        $soldItem = SoldItem::where('user_id', $user_id)
                        ->where('item_id', $item->id)
                        ->first();

        $paymentMethodId = $soldItem ? $soldItem->payment_method_id : 1;
        $paymentMethod = PaymentMethod::find($paymentMethodId);

        if (is_null($soldItem) || is_null($soldItem->payment_method_id)) {
            $paymentMethod = 1;
        } else {
            $paymentMethod = $soldItem->payment_method_id;
        }

        if (!$paymentMethod) {
            return back()->withErrors(['message' => '支払い方法が設定されていません。']);
        }

        $soldItem = SoldItem::updateOrCreate([
            'user_id' => $user_id,
            'item_id' => $item->id,
        ], [
            'payment_method_id' => $paymentMethod,
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price, 
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.complete', ['item' => $item->id]),
        ]);

        if ($paymentMethod == 1) {
            return redirect()->route('checkout', ['session_id' => $session->id]);
        } else {
            return redirect()->route('purchase.complete', ['item' => $item->id]);
        }
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
