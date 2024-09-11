<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\SoldItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
