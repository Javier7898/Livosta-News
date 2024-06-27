<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminController;
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

    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index'); // Route to show all feedback
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::get('/feedback/{feedback}/edit', [FeedbackController::class, 'edit'])->name('feedback.edit');
    Route::put('/feedback/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update'); // Add this line
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy'); // Corrected method for destroy
});

    // Route untuk logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');


// Route untuk autentikasi
Auth::routes();

// Route untuk administrator (membutuhkan autentikasi dan memiliki peran admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/news', [NewsController::class, 'adminIndex'])->name('admin.news.index');
    Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/admin/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/admin/news/{id}/edit', [NewsController::class, 'edit']);
    Route::put('/admin/news/{id}', [NewsController::class, 'update']);
    Route::delete('/admin/news/{id}', [NewsController::class, 'destroy']);
    Route::post('/admin/news/{id}/highlight', [NewsController::class, 'highlight'])->name('admin.news.highlight');
    Route::delete('/news/{id}/unhighlight', [NewsController::class, 'unhighlight'])->name('news.unhighlight');
    Route::post('/admin/feedback/{feedback}/approve', [FeedbackController::class, 'approve'])->name('admin.approveFeedback');
    Route::post('/admin/feedback/{feedback}/reject', [FeedbackController::class, 'reject'])->name('admin.rejectFeedback');

});
