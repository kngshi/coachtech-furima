<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser()
    {
        $user= User::select('id')->get();

        return view('mypage', compact('user'));
    }

    public function editProfile()
    {
        // ログインユーザーのIDを取得
        $userId = Auth::id();

        return view('profile', compact('userId'));
    }
}
