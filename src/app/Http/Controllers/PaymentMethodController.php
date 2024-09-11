<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function edit(Item $item)
    {
        $user = Auth::user();

        $paymentMethod = SoldItem::where('user_id', $user->id)
                            ->where('item_id', $item->id)
                            ->pluck('payment_method_id')
                            ->first();

        $paymentMethod = $paymentMethod ?? 1;

        return view('payment-method', compact('user','item', 'paymentMethod'));
    }

    public function update(Request $request,Item $item)
    {
        $validatedData = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $user_id = Auth::id();
        $paymentMethod = $validatedData['payment_method_id'];

        SoldItem::updateOrCreate(
            [
                'user_id' => $user_id,
                'item_id' => $item->id,
            ],
            [
                'payment_method_id' => $paymentMethod,
            ]
        );

        return redirect()->route('purchase.info', ['item' => $item->id])
                    ->with('payment_method_id', $paymentMethod)
                    ->with('success', '支払い方法を更新しました。');
    }
}
