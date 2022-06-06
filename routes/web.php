<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//middleware(['auth'])
Route::middleware(['auth'])->group(function () {
    //メイン画面 相手を表示しlikes or unLikes ボタンを設置する。
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    //likes or unLikesメソッドをswipesに保存するメソッド
    Route::post('/users/{user}', [UserController::class, 'store'])->name('users.store');
    //マッチしたユーザー一覧を表示する。
    Route::get('/users/matches', [UserController::class, 'matches'])->name('users.matches');
    // users.show(マッチングしたユーザーのプロフィールを表示するルート)
    Route::get('/users/matches/{num}', [UserController::class, 'matches_show'])->name('users.matches_show');
    //users.room(マッチングしたユーザーとチャットするルート）
    Route::get('/users/room/{user}', [UserController::class, 'room'])->name('users.room');
    //ユーザーとの個人メッセージの取得メソッド
    Route::get('/users/room/{user}/messages', [UserController::class, 'get_messages'])->name('get_messages');
    //ユーザーとの個人メッセージの保存・イベントの発火メソッド
    Route::post('/users/room/{user}/store', [UserController::class, 'store_message'])->name('store_message');
    //プロフィール編集画面表示
    Route::get('/profile', [UserController::class, 'profileShow'])->name('users.profile');
    //プロフィール編集
    Route::put('/profile', [UserController::class, 'profileUpdate'])->name('profile_edit');
    //パスワード編集
    Route::put('/password_change', [UserController::class, 'passwordUpdate'])->name('password_edit');
});

Route::get('logout', function ()
{
    auth()->logout();
    Session()->flush();
    return Redirect::to('/');
})->name('logout');

