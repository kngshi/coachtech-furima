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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Requests\SellRequest;


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

    public function search(Request $request)
    {
        $query = Item::query();

        if ($request->filled('keyword') || $request->filled('category_id')) {
            $keyword = $request->input('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhere('brand', 'LIKE', "%{$keyword}%")
                ->orWhereHas('categories', function($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            });
        } else {
            $keyword = '';
        }

        if ($request->filled('category_id')) {
            $category_ids = $request->input('category_id');

            if (!is_array($category_ids)) {
                $category_ids = [$category_ids];
            }

            $query->whereHas('categories', function ($q) use ($category_ids) {
                $q->whereIn('categories.id', $category_ids);
            });
        }

        $items = $query->get();

        return view('components.search-results', compact('items', 'keyword'));
    }

    public function searchByCategory(Request $request)
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('search.category', compact('categories'));
    }

    public function showCategories($id)
    {
        $category = Category::findOrFail($id);
        $childCategories = $category->children;

        if ($childCategories->isEmpty()) {
            return redirect()->route('search', ['category_id' => $id]);
        }

        return view('search.category-show', compact('category', 'childCategories'));
    }

    public function itemDetail(Item $item)
    {
        $item->load('categories', 'condition');
        return view('item', compact('item'));
    }

    public function postDetail(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        return redirect()->route('purchase.info', ['item' => $item_id]);
    }

    public function purchaseInformation(Item $item)
    {
        $user_id = Auth::id();

        $soldItem = SoldItem::where('user_id', $user_id)
                        ->where('item_id', $item->id)
                        ->first();

        if (is_null($soldItem) || is_null($soldItem->payment_method_id)) {
            $paymentMethod = PaymentMethod::find(1);
        } else {
            $paymentMethod = PaymentMethod::find($soldItem->payment_method_id);
        }

        return view('purchase', compact('item', 'paymentMethod'));
    }

    public function purchaseItem(Request $request, Item $item)
    {
        $user = Auth::user();
        $user_id = Auth::id();

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

    public function storeItem(SellRequest $request)
    {
        $user_id = Auth::id();

        $validatedData = $request->validated();

        if ($request->hasFile('img_url')) {
            $image = $request->file('img_url');
            $s3ImagePath = $image->store('items', 's3');
            $s3ImageUrl = Storage::disk('s3')->url($s3ImagePath);
        } else {
            $s3ImageUrl = null;
        }

        $item = Item::create([
            'name' => $validatedData['name'],
            'brand' => $validatedData['brand'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'img_url' => $s3ImageUrl,
            'user_id' => $user_id,
            'condition_id' => $validatedData['condition_id'],
        ]);

        if ($request->filled('category')) {
            $categories = $request->input('category');
            foreach ($categories as $categoryId) {
                DB::table('category_items')->insert([
                    'item_id' => $item->id,
                    'category_id' => $categoryId,
                ]);
            }
        }

        return redirect()->route('mypage', compact('user_id'))
            ->with('success', '商品を出品しました。');
    }

    public function getChildCategories($parentId)
    {
        $childCategories = Category::where('parent_id', $parentId)->get();

        return response()->json($childCategories);
    }
}
