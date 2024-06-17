<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);

Route::get('password/reset/email', [PasswordResetController::class, 'showEmailForm'])->name('password.email');
Route::post('password/reset/favorite-word', [PasswordResetController::class, 'confirmFavoriteWord'])->name('password.favorite_word');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/news', [NewsController::class, 'adminIndex']);
        Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/admin/news', [NewsController::class, 'store'])->name('news.store');
        Route::get('/admin/news/{id}/edit', [NewsController::class, 'edit']);
        Route::put('/admin/news/{id}', [NewsController::class, 'update']);
        Route::delete('/admin/news/{id}', [NewsController::class, 'destroy']);
    });
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
