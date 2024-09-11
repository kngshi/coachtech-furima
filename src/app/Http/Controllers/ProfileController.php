<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdateAddressRequest;

class ProfileController extends Controller
{
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
            $s3ImagePath = $image->store('users', 's3');
            $imageUrl = Storage::disk('s3')->url($s3ImagePath);
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
