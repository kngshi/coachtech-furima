<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

// トップページ
Route::get('/', [ItemController::class, 'index'])->name('index');

// 商品詳細ページ
Route::get('/item/{item}', [ItemController::class, 'itemDetail'])->name('item.detail');
Route::post('/item/{item}/like', [LikeController::class, 'like'])->name('item.like');
Route::delete('/item/{item}/unlike', [LikeController::class, 'unlike'])->name('item.unlike');

//詳細ページの「購入する」ボタンから、購入ページ(/purchase/:item_id)への遷移(データ送信)
Route::post('/purchase', [ItemController::class, 'postDetail'])->name('post.detail');

// 購入ページの表示
Route::get('/purchase/{item}', [ItemController::class, 'purchaseInformation'])->name('purchase.information');

//購入ページから、購入確定のアクション
Route::post('/purchase/{item}', [ItemController::class, 'purchaseItem'])->name('purchase.item');

//購入完了ページの表示
Route::get('/purchase/{item}/complete', [ItemController::class, 'purchaseComplete'])->name('purchase.complete');

//住所変更のページ表示
Route::get('/purchase/address/{item}', [ProfileController::class, 'editAddress'])->name('edit.address');

//住所変更のデータ送信
Route::put('/purchase/address/{item}', [ProfileController::class, 'updateAddress'])->name('update.address');


Route::middleware(['auth'])->group(function () {

    Route::get('/purchase/{item}', [ItemController::class, 'purchaseInformation'])->name('item.purchase');

    Route::get('/sell', [ItemController::class, 'createItem'])->name('sell.create');
    Route::post('/sell', [ItemController::class, 'storeItem'])->name('sell.store');

    Route::get('/mypage', [UserController::class, 'getUser'])->name('mypage');
    //プロフィール変更ページ表示
    Route::get('/mypage/profile', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::post('/mypage/profile', [UserController::class, 'storeProfile'])->name('store.profile');

    // コメント追加・削除機能
    Route::get('/item/{item}/comment', [CommentController::class, 'createComment'])->name('create.comment');
    Route::post('/item/{item}/comment', [CommentController::class, 'storeComment'])->name('store.comment');
    Route::delete('/item/{item}/comment/{comment}', [CommentController::class, 'destroyComment'])->name('destroy.comment');

});
