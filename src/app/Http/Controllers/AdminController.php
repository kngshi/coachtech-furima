<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Comment;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function admin()
    {
        $users = User::with('profile')->get();
        return view('admin.admin');
    }

    public function userIndex()
    {
        $users = User::with('profile')->get();

        return view('admin.user-index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->profile;
        return response()->json([
            'user' => $user,
            'profile' => $profile
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->profile()->delete();
        $user->delete();

        return redirect()->route('admin.user-index')->with('success', 'ユーザーが削除されました');
    }

    public function index()
    {
        $items = Item::with('comments')->get();

        return view('admin.comments', compact('items'));
    }

    public function notifyMail(Request $request)
    {
        return view("admin/notify");
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->queue(new NotifyMail($request->subject, $request->message));
        }

        return redirect()->route('admin.notify')->with('success', 'メールの送信に成功しました。');
    }
}
