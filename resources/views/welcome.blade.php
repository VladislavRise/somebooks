<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Somebooks</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ env('APP_URL') }}/build/assets/app-550d0007.css" />
        <link rel="stylesheet" href="/style.css" />
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-2 lg:p-8">
                <b>Выберите запрос к API:</b>
                <div class="button-container mt-2">
                    <button id="books">Список книг</button>
                    <button id="genres">Список жанров</button>
                    <button id="authors">Список авторов</button>
                    <button id="getBook">Книна по id</button>
                    <button id="getAuthor">Автор по id</button>
                </div>
                <div class="button-container mb-6">
                    <button id="formLogin">Авторизация</button>
                    <button id="formAuthor">Обновить данные автора</button>
                    <button id="formBook">Обновить данные книги</button>
                    <button id="delBook">Удалить книгу</button>
                </div>
                <div id="formsContainer">

                </div>
                <div class="mt-10">
                    <b>JSON ответ:</b>
                    <iframe id="jsonViewer" style="width: 100%; height: 400px;">
                    </iframe>
                    <div class="button-container mt-2">
                        <button id="prev" class="bg-gray-500 hover:bg-gray-700 text-white rounded">Назад</button>
                        <button id="next" class="bg-gray-500 hover:bg-gray-700 text-white rounded">Вперёд</button>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>

<script src="script.js"></script>