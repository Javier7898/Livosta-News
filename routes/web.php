<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama dan tampilan berita
Route::get('/', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/category/{category}', [NewsController::class, 'newsByCategory'])->name('news.category');
Route::get('/filter-news', [NewsController::class, 'filter'])->name('news.filter');
Route::get('/search-news', [NewsController::class, 'search'])->name('news.search');

// Route untuk menambah dan menghapus dari favorit
Route::post('/news/{id}/favorite', [NewsController::class, 'favorite'])->name('news.favorite'); // Metode POST untuk menambah ke favorit
Route::delete('/news/{id}/favorite', [NewsController::class, 'unfavorite'])->name('news.unfavorite'); // Metode DELETE untuk menghapus dari favorit

// Route untuk menampilkan daftar favorit
Route::get('/favorites', [NewsController::class, 'favorites'])->name('favorites');

// Route untuk menyimpan komentar
Route::post('/news/{newsId}/comments', [CommentController::class, 'store'])->name('comments.store');

// Middleware untuk mengharuskan autentikasi pengguna
Route::middleware(['auth'])->group(function () {
    // Route untuk mengedit dan menghapus komentar
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Route untuk logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

// Route untuk autentikasi
Auth::routes();

// Route untuk administrator (membutuhkan autentikasi dan memiliki peran admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/news', [NewsController::class, 'adminIndex'])->name('admin.news.index');
    Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/admin/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/admin/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/admin/news/{id}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/admin/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');
});

