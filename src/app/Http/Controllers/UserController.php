<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;


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

    public function storeProfile(ProfileRequest $request)
    {
        $user_id = Auth::id();

        if ($request->has('name')) {
            Auth::user()->update(['name' => $request->input('name')]);
        }

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

        return redirect()->route('mypage', compact('user_id'))
        ->with('success', 'プロフィールを更新しました。');
    }
}
