<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Роуты профилей пользователей
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Роуты книг
    Route::get('/book/mylist', [BookController::class, 'myList'])->name('book.mylist');
    Route::get('/book/list', [BookController::class, 'list'])->name('book.list');
    Route::get('/book/add', [BookController::class, 'viewAdd'])->name('book.add');
    Route::post('/book/add', [BookController::class, 'add'])->name('book.add');
    Route::get('/book/{id}/update', [BookController::class, 'viewUpdate'])->name('book.update');
    Route::post('/book/{id}/update', [BookController::class, 'update'])->name('book.update');
    Route::get('/book/{id}/del', [BookController::class, 'del'])->name('book.del');
   
    // Роуты жанров
    Route::get('/genres/list', [GenreController::class, 'list'])->name('genres.list');
    Route::post('/genres/add', [GenreController::class, 'add'])->name('genres.add');
    Route::get('/genres/{id}/update', [GenreController::class, 'viewUpdate'])->name('genres.update');
    Route::post('/genres/{id}/update', [GenreController::class, 'update'])->name('genres.update');
    Route::get('/genres/{id}/del', [GenreController::class, 'del'])->name('genres.del');

    // Роуты Авторов
    Route::get('/authors/list', [AuthorController::class, 'list'])->name('authors.list');
    Route::get('/authors/{id}/update', [AuthorController::class, 'viewUpdate'])->name('author.update');
    Route::patch('/authors/{id}/update', [AuthorController::class, 'update'])->name('author.update');
    Route::get('/authors/{id}/del', [AuthorController::class, 'del'])->name('author.del');
});

require __DIR__.'/auth.php';
