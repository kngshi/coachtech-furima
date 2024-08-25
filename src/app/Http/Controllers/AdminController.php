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
        $profile = $user->profile; // Profileテーブルとのリレーションを使用
        return response()->json([
            'user' => $user,
            'profile' => $profile
        ]);
    }

    public function destroy($id)
    {
         // 指定されたIDのユーザーを取得
        $user = User::findOrFail($id);

        // ユーザーと関連するプロフィールを削除
        $user->profile()->delete(); // ProfileがUserに関連付けられている場合
        $user->delete(); // ユーザー自体を削除

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
