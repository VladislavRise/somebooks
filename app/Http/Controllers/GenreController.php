<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreAddRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Genre;


class GenreController extends Controller
{
    /* Форма добавления жанра и список жанров */
    public function list(): View
    {
        $genres = Genre::all(); // Получение всех жанров

        return view('genre.list', 
            ['genres' => $genres]
        );
    }

    /* Добавления жанра. */
    public function add(GenreAddRequest $request): RedirectResponse
    {
        Genre::create($request->all());

        // Редирект в список жанров
        return redirect()->route('genres.list')->with('success', 'Done');
    }

    /* Форма редактирования жанра. */
    public function viewUpdate(Genre $id): View
    {
        return view('genre.update', [
            'genre' => $id
        ]);
    }

    /* Обновление жанра. */
    public function update(Genre $id, GenreAddRequest $request): RedirectResponse
    {   
        $id->update($request->all());

        return Redirect::route('genres.list')->with('status', 'Done');
    }

    /* Удаление жанра. */
    public function del(Genre $id): RedirectResponse
    {   
        $id->delete();

        return Redirect::route('genres.list')->with('status', 'Done');
    }

    
    /*##### API-методы #####*/

    /* Список Жанров с количеством книг (пагинация по 5 шт.) */
    public function apiList($page = null)
    {
        $books = Genre::with('books:id,name')->simplePaginate(5, ['*'], 'page', $page);

        return response()->json($books);
    }
}
