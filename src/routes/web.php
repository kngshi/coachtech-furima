<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\AdminController;


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

Route::get('/', [ItemController::class, 'index'])->name('index');

//検索機能
Route::get('/search', [ItemController::class, 'search'])->name('search');
Route::get('/search/category', [ItemController::class, 'searchByCategory'])->name('search.category');
Route::get('search/categories/{id}', [ItemController::class, 'showCategories'])->name('show.categories');

Route::get('/item/{item}', [ItemController::class, 'itemDetail'])->name('item.detail');

Route::middleware(['auth'])->group(function () {

    Route::post('/item/{item}/like', [LikeController::class, 'like'])->name('item.like');
    Route::delete('/item/{item}/unlike', [LikeController::class, 'unlike'])->name('item.unlike');

    //購入ページ
    Route::post('/purchase', [ItemController::class, 'postDetail'])->name('post.detail');
    Route::get('/purchase/{item}', [ItemController::class, 'purchaseInformation'])->name('purchase.info');
    Route::post('/purchase/{item}', [ItemController::class, 'purchaseItem'])->name('purchase.item');

    // 支払い方法変更ページ
    Route::get('/purchase/{item}/payment-method/edit', [PaymentMethodController::class, 'edit'])->name('payment.method.edit');
    Route::post('/purchase/{item}/payment-method/update', [PaymentMethodController::class, 'update'])->name('payment.method.update');

    //住所変更ページ
    Route::get('/purchase/address/{item}', [ProfileController::class, 'editAddress'])->name('edit.address');
    Route::put('/purchase/address/{item}', [ProfileController::class, 'updateAddress'])->name('update.address');

    // Stripe Checkoutの開始
    Route::get('/checkout/{session_id}', function ($session_id) {
        return view('checkout', ['session_id' => $session_id]);
    })->name('checkout');

    //購入完了ページの表示
    Route::get('/purchase/{item}/complete', [ItemController::class, 'purchaseComplete'])->name('purchase.complete');

    //出品ページ
    Route::get('/sell', [ItemController::class, 'createItem'])->name('sell.create');
    Route::post('/sell', [ItemController::class, 'storeItem'])->name('sell.store');

    //マイページ
    Route::get('/mypage', [UserController::class, 'getUser'])->name('mypage');

    //プロフィール変更ページ表示
    Route::get('/mypage/profile', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::post('/mypage/profile', [UserController::class, 'storeProfile'])->name('store.profile');

    // コメント追加・削除機能
    Route::get('/item/{item}/comment', [CommentController::class, 'createComment'])->name('create.comment');
    Route::post('/item/{item}/comment', [CommentController::class, 'storeComment'])->name('store.comment');
    Route::delete('/item/{item}/comment/{comment}', [CommentController::class, 'destroyComment'])->name('destroy.comment');
});


// 管理者用ルート
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'admin'])->name('admin');
    Route::get('/user-index', [AdminController::class, 'userIndex'])->name('admin.user-index');
    Route::get('/user-index/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::delete('/user-index/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::get('/notify', [AdminController::class, 'notifyMail'])->name('admin.notify');
    Route::post('/notify', [AdminController::class, 'send'])->name('admin.notify.send');

    // コメント追加・削除機能
    Route::get('/item/{item}/comment', [CommentController::class, 'createComment'])->name('create.comment');
    Route::post('/item/{item}/comment', [CommentController::class, 'storeComment'])->name('store.comment');
    Route::delete('/item/{item}/comment/{comment}', [CommentController::class, 'destroyComment'])->name('destroy.comment');
    Route::get('comments', [AdminController::class, 'index'])->name('admin.comments');
});