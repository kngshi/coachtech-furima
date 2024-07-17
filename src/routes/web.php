<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

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


Route::get('/', function () {
    return view('index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// トップページ
Route::get('/', [ItemController::class, 'index'])->name('index');

// 商品詳細ページ
Route::get('/item/{item}', [ItemController::class, 'itemDetail'])->name('item.detail');

//詳細ページの「購入する」ボタンから、購入ページ(/purchase/:item_id)への遷移(データ送信)
Route::post('/purchase', [ItemController::class, 'postDetail'])->name('post.detail');

// 購入ページの表示
Route::get('/purchase/{item}', [ItemController::class, 'purchaseInformation'])->name('purchase.information');

//購入ページから、購入確定のアクション
Route::post('/purchase/{item}', [ItemController::class, 'purchaseItem'])->name('purchase.item');

Route::get('/purchase/{item}/complete', [ItemController::class, 'purchaseComplete'])->name('purchase.complete');


Route::middleware(['auth'])->group(function () {

    Route::get('/purchase/{item}', [ItemController::class, 'purchaseInformation'])->name('item.purchase');

    Route::get('/sell', [ItemController::class, 'create']);
    Route::post('/sell', [ItemController::class, 'store']);

    Route::get('/mypage', [UserController::class, 'getUser'])->name('mypage');

    Route::get('/mypage/profile', [UserController::class, 'editProfile'])->name('editProfile');

});
