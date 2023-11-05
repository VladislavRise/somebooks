<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Роуты API для всех */
Route::group([], function () {

    // Получение списка Книг с пагинацией по 5 шт.
    Route::get('/books/{page?}', [BookController::class, 'apiList']);
    // Получение Книги по Id
    Route::get('/book/{id}', [BookController::class, 'apiBook']);

    // Получение списка Авторов с пагинацией по 5 шт.
    Route::get('/authors/{page}', [AuthorController::class, 'apiList']);
    // Получение Автора по Id
    Route::get('/author/{id}', [AuthorController::class, 'apiAuthor']);

    // Получение списка Жанров с пагинацией по 5 шт.
    Route::get('/genres/{page}', [GenreController::class, 'apiList']);

    // Авторизация.
    Route::post('/login', [AuthenticatedSessionController::class, 'login']);
});

/* Роуты API для Авторизованных */
Route::middleware('auth:sanctum')->group(function () {

    // Обновление данных Автора
    Route::post('/author/update', [AuthorController::class, 'apiAuthorUpdate']);

    // Обновление данных Книги по Id (Если юзер автор книги)
    Route::post('/book/update', [BookController::class, 'apiBookUpdate']);

    // Удаление Книги по Id (Если юзер автор книги)
    Route::post('/book/delBook', [BookController::class, 'apiBookDel']);

});