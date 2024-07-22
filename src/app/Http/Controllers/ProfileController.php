<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function editAddress(Item $item)
    {
        return view('address', compact('item'));
    }

    public function updateAddress(Request $request, Item $item)
    {
        $user_id = Auth::id();

        $request->validate([
            'postcode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $profile = Profile::updateOrCreate(
        ['user_id' => $user_id],
            [
                'postcode' => $request->input('postcode'),
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]
        );

        return redirect()->route('edit.address', $item->id)->with('success', '住所が更新されました');
    }
}
