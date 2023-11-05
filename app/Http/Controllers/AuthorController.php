<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\API\APIAuthorUpdateRequest;
use Illuminate\View\View;
use App\Models\Author;


class AuthorController extends Controller
{
    /* Список всех авторов. */
    public function list(): View
    {
        return view('author.list', [
            'authors' =>  Author::all(),
        ]);
    }

    /* Форма редактирования автора. */
    public function viewUpdate(Author $id): View
    {
        return view('author.update', [
            'author' => $id
        ]);
    }

    /* Обновление данных автора */
    public function update(Author $id, ProfileUpdateRequest $request): RedirectResponse
    {   
        $id->update($request->all());
        
        return Redirect::route('authors.list')->with('status', 'Done');
    }

    /* Удаление автора */
    public function del(Author $id): RedirectResponse
    {
        $id->delete();  // Каскадное удаление Автора, со всеми книгами и отвязка от жанров т.к. в миграциях всё прописано >_<

        return Redirect::route('authors.list')->with('status', 'Done');
    }


    /*##### API-методы #####*/

    /* Список авторов с количеством книг (пагинация по 5 шт.)*/
    public function apiList($page = null)
    {
        $books = Author::withCount('books')->simplePaginate(5, ['*'], 'page', $page);

        return response()->json($books);
    }

    /* Автор по Id */
    public function apiAuthor($id)
    {
        $author = Author::with('books:id,name')->find($id);
        $author = $author ? $author : 'Нет такого Автора';

        return response()->json($author);
    }

    /* Обновление данных Автор по */
    public function apiAuthorUpdate(APIAuthorUpdateRequest $request)
    {   
        $user = Auth::user();

        if(!$user->author) return response()->json('Вы не автор');

        $user->author->update($request->all());
        return response()->json('Updated');

    }
}
