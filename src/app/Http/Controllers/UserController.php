<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getUser()
    {
        $user_id = Auth::id();

        $profile = Profile::where('user_id', $user_id)->first();

        $items = Item::where('user_id', $user_id)->get();

        $soldItems = SoldItem::where('user_id', $user_id)->with('item')->get();

        return view('mypage', compact('profile', 'items', 'soldItems'));
    }

    public function editProfile()
    {
        $user_id = Auth::id();

        $profile = Auth::user()->profile;

        return view('profile', compact('user_id','profile'));
    }

    public function storeProfile(Request $request)
    {
        $user_id = Auth::id();

        $validatedData = $request->validate([
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'postcode' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'building' => 'nullable|string|max:191',
        ]);

        if ($request->hasFile('img_url')) {
            $image = $request->file('img_url');
            $imagePath = $image->store('profiles', 'public');
            $imageUrl = Storage::url($imagePath);
        } else {
            $imageUrl = Auth::user()->profile->img_url ?? null;
        }

        $profile = Profile::updateOrCreate(
            ['user_id' => $user_id],
            [
                'img_url' => $imageUrl,
                'postcode' => $request->input('postcode'),
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]
        );

        return redirect()->route('store.profile', compact('user_id'))
        ->with('success', 'プロフィールを更新しました。');
    }
}
