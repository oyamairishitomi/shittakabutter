<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShittakaController;
use App\Http\Controllers\AdminController;

// ログイン・ログアウト・新規登録
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout',[UserController::class, 'logout']);
Route::get('/register',[UserController::class, 'showRegister']);
Route::post('/register', [UserController::class, 'register']);

// 管理者用のログイン・ログアウト
Route::get('/admin/login', [AdminController::class, 'showLogin']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout']);

// 管理者のみのページ
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users']);
});

// ログイン状態でアクセスできるダッシュボード・削除機能
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ShittakaController::class, 'dashboard']);
    Route::post('/transcribe', [ShittakaController::class, 'transcribe']);
    Route::delete('/delete/{id}', [ShittakaController::class, 'destroy']);
});