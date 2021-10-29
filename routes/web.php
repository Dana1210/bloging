<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\PostContrpller as AdminPostController;

Route::group(['middleware' => ['auth','changeloc']], function (){
    Route::resource('posts', PostController::class)->except(['index', 'show']);
    Route::resource('comments', CommentController::class);
    Route::get('like/{post}', [PostController::class, 'likePost'])->name('likepost');

    Route::group([
        'middleware' => 'isAdmin',
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function (){
        Route::resource('posts', AdminPostController::class);
    });
});

Route::resource('posts', PostController::class)->only(['index', 'show'])->middleware('changeloc');
Route::get('posts/category/{category}',[PostController::class, 'categoryPosts'])->name('posts.category');

Route::get('/', function(){
    return redirect()->route('posts.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
