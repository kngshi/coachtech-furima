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
Route::get('/item/{item}', [ItemController::class, 'itemDetail'])->name('item.detail');

Route::get('/search', [ItemController::class, 'search'])->name('search');
Route::get('/search/category', [ItemController::class, 'searchByCategory'])->name('search.category');
Route::get('search/categories/{id}', [ItemController::class, 'showCategories'])->name('show.categories');

Route::middleware(['auth'])->group(function () {

    Route::post('/item/{item}', [ItemController::class, 'postDetail'])->name('post.detail');

    Route::get('/purchase/{item}', [ItemController::class, 'purchaseInformation'])->name('purchase.info');
    Route::post('/purchase/{item}', [ItemController::class, 'purchaseItem'])->name('purchase.item');

    Route::get('/purchase/{item}/payment-method/edit', [PaymentMethodController::class, 'edit'])->name('payment.method.edit');
    Route::post('/purchase/{item}/payment-method/update', [PaymentMethodController::class, 'update'])->name('payment.method.update');

    Route::get('/purchase/address/{item}', [ProfileController::class, 'editAddress'])->name('edit.address');
    Route::put('/purchase/address/{item}', [ProfileController::class, 'updateAddress'])->name('update.address');

    Route::get('/checkout/{session_id}', function ($session_id) {
        return view('checkout', ['session_id' => $session_id]);
    })->name('checkout');

    Route::get('/purchase/{item}/complete', [ItemController::class, 'purchaseComplete'])->name('purchase.complete');

    Route::get('/sell', [ItemController::class, 'createItem'])->name('sell.create');
    Route::post('/sell', [ItemController::class, 'storeItem'])->name('sell.store');
    Route::get('/get-child-categories/{parentId}', [ItemController::class, 'getChildCategories']);

    Route::get('/mypage', [UserController::class, 'getUser'])->name('mypage');

    Route::get('/mypage/profile', [ProfileController::class, 'editProfile'])->name('edit.profile');
    Route::post('/mypage/profile', [ProfileController::class, 'storeProfile'])->name('store.profile');

    Route::post('/item/{item}/like', [LikeController::class, 'like'])->name('item.like');
    Route::delete('/item/{item}/unlike', [LikeController::class, 'unlike'])->name('item.unlike');

    Route::get('/item/{item}/comment', [CommentController::class, 'create'])->name('create.comment');
    Route::post('/item/{item}/comment', [CommentController::class, 'store'])->name('store.comment');
    Route::delete('/item/{item}/comment/{comment}', [CommentController::class, 'destroy'])
        ->middleware('can:delete,comment')
        ->name('destroy.comment');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'admin'])->name('admin');
    Route::get('/user-index', [AdminController::class, 'userIndex'])->name('admin.user-index');
    Route::get('/user-index/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::delete('/user-index/{id}', [AdminController::class, 'destroyUser'])->name('admin.delete');
    Route::get('/notify', [AdminController::class, 'notifyMail'])->name('admin.notify');
    Route::post('/notify', [AdminController::class, 'send'])->name('admin.notify.send');

    Route::get('comments', [AdminController::class, 'index'])->name('admin.comments');
    Route::delete('/item/{item}/comment/{comment}', [AdminController::class, 'destroyComment'])->name('admin.destroy.comment');
});