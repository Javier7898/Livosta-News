<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);


// Comment store route
// Route::get('/news/{news}', [CommentController::class, 'show'])->name('comments.show');
Route::post('/news/{newsId}/comments', [CommentController::class, 'store'])->name('comments.store');


Route::middleware(['auth'])->group(function () {
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



// Auth routes
Auth::routes();
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/news', [NewsController::class, 'adminIndex']);
    Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/admin/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/admin/news/{id}/edit', [NewsController::class, 'edit']);
    Route::put('/admin/news/{id}', [NewsController::class, 'update']);
    Route::delete('/admin/news/{id}', [NewsController::class, 'destroy']);

    Route::post('/admin/feedback/{feedback}/approve', [FeedbackController::class, 'approve'])->name('admin.approveFeedback');
    Route::post('/admin/feedback/{feedback}/reject', [FeedbackController::class, 'reject'])->name('admin.rejectFeedback');

});
