<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $payment_method = session('payment_method',0);

        return view('payment-method', compact('user', 'payment_method'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => 'required|exists:items,id',
            'payment_method' => 'required|in:0,1,2',
        ]);

        $user_id = Auth::id();

        $request->session()->put('payment_method', $validatedData['payment_method']);

        $item = Item::find($validatedData['item_id']);
        $paymentMethod = $validatedData['payment_method'];

        return view('purchase', compact('item', 'paymentMethod'))
            ->with('success', '支払い方法を更新しました。');
    }
}
