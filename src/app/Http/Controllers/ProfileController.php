<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateAddressRequest;

class ProfileController extends Controller
{
    public function editAddress(Item $item)
    {
        return view('address', compact('item'));
    }

    public function updateAddress(UpdateAddressRequest $request, Item $item)
    {
        $user_id = Auth::id();

        $profile = Profile::updateOrCreate(
        ['user_id' => $user_id],
            [
                'postcode' => $request->input('postcode'),
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]
        );

        return redirect()->route('purchase.info', $item->id)->with('success', '住所が更新されました');
    }
}
