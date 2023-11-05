<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if( auth()->user()->role == 'admin' )
                    <div>
                        <b>Вы вошли в аккаунт Администратора</b><br>
                        Возможности Администратора:<br>
                        1. CRUD с Жанрами.<br>
                        2. Изменять/Удалять Авторов.<br>
                        3. Изменять/Удалять Книги.<br>
                        4. Быть автором :)<br>
                    </div>
                    @endif
                    @if( auth()->user()->role == 'author' )
                    <div>
                        <b>Вы вошли в аккаунт Автора</b><br>
                        Возможности Автора:<br>
                        1. Публиковать книги после заполнения данных автора<br>
                        2. Изменять/Удалять свои книги.<br>
                        3. Изменять/Удалять свои данные Автора.<br>
                    </div>
                    @endif
                    @if( auth()->user()->role == 'user' )
                    <div>
                        <b>Вы вошли в аккаунт Обычного пользователя</b><br>
                        Вы можете только просматривать информацию.<br>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
