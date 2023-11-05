<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookAddRequest;
use App\Http\Requests\API\APIBookUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Book;
use App\Models\Genre;


class BookController extends Controller
{
    /* Список моих книг */
    public function myList(): View
    {
        $author = auth()->user()->author;
        $books =  $author ? $author->books()->get() : [];

        return view('book.list', [
            'books' => $books
        ]);
    }

    /* Список всех книг */
    public function list(): View
    {
        return view('book.list', [
            'books' => Book::all()
        ]);
    }

    /* Форма добавления книги. */
    public function viewAdd(): View
    {
        return view('book.add', [
            'genres' =>  Genre::all(),
        ]);
    }

    /* Добавление книги */
    public function add(BookAddRequest $request): RedirectResponse
    {
        $author = auth()->user()->author;
        $book = $author->books()->create($request->all());
        $book->genres()->attach($request->input('genre'));

        \Log::info('Добавлена книга: '.$book->name);

        return Redirect::route('book.mylist')->with('status', 'Done');
    }

    /* Форма редактирования книги. */
    public function viewUpdate(Book $id): View
    {
        return view('book.update', [
            'book' => $id,
            'genres' =>  Genre::all()
        ]);
    }

    /* Обновление данных книги */
    public function update(Book $id, BookAddRequest $request): RedirectResponse
    {   
        $id->update($request->all());
        $id->genres()->sync($request->input('genre'));

        \Log::info('Изменена книга: '.$id->name);

        return Redirect::route('book.list')->with('status', 'Done');
    }

    /* Удаление книги */
    public function del(Book $id): RedirectResponse
    {
        \Log::info('Изменена книга: '.$id->name);

        $id->delete();
        return Redirect::route('book.list')->with('status', 'Done');
    }
    
    /*##### API-методы #####*/

    /* Список всех книг (пагинация по 5 шт)*/
    public function apiList($page = null)
    {
        $books = Book::with('author:id,nickname')->simplePaginate(5, ['*'], 'page', $page);

        return response()->json($books);
    }

    /* Книга по Id */
    public function apiBook($id)
    {
        $book = Book::with('author:id,nickname')->find($id);
        $book = $book ? $book : 'Нет такой книги';

        return response()->json($book);
    }

    /* Обновление данных книга по Id (Если юзер её автора) */
    public function apiBookUpdate(APIBookUpdateRequest $request)
    {
        $book = Book::find($request->id);

        // Ответ если нет книги
        if(!$book) return response()->json('No Book');
        // Ответ если запрос не от Автора
        if(Auth::user()->author->id != $book->author_id) return response()->json('Not Author');

        $book->update($request->all());
        $book->genres()->sync($request->input('genre'));

        \Log::info('По API Изменена книга: '.$book->name);
    
        return response()->json('Updated');
    }

    /* Удаление по Id (Если юзер её автора) */
    public function apiBookDel(Request $request)
    {
        $book = Book::find($request->id);

        // Ответ если нет книги
        if(!$book) return response()->json('No Book');
        // Ответ если запрос не от автора
        if(Auth::user()->author->id != $book->author_id) return response()->json('Not Author');

        $book->delete();
    
        return response()->json('Deleted');
    }
}
