<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getUser()
    {
       // ログインユーザーのIDを取得
        $user_id = Auth::id();

        // ログインユーザーのプロフィール情報を取得
        $profile = Profile::where('user_id', $user_id)->first();

        return view('mypage', compact('profile'));
    }

    public function editProfile()
    {
        // ログインユーザーのIDを取得
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

        // プロフィール画像のアップロード処理
        if ($request->hasFile('img_url')) {
            $image = $request->file('img_url');
            $imagePath = $image->store('profiles', 'public');
            $imageUrl = Storage::url($imagePath);
        } else {
            $imageUrl = Auth::user()->profile->img_url ?? null;
        }

        // プロフィール情報の更新または作成
        $profile = Profile::updateOrCreate(
            ['user_id' => $user_id], // 検索条件
            [
                'img_url' => $imageUrl,
                'postcode' => $request->input('postcode'),
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]
        );

    // プロフィールページにリダイレクト
    return redirect()->route('store.profile', compact('user_id'))
        ->with('success', 'プロフィールを更新しました。');
    }
}
