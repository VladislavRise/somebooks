<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Список книг
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <table class="">
                        <thead>
                            <tr>
                                <th class="px-2 py-3 text-left">Книга</th>
                                <th class="px-2 py-3 text-left">Автор</th>
                                <th class="px-2 py-3 text-left">Тип</th>
                                <th class="px-2 py-3 text-left">Жанры</th>
                                <th class="px-2 py-3 text-left">Дата выхода</th>
                                <th class="px-2 py-3 text-left">Добавлено</th>
                                <th class="px-2 py-3 text-center">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td class="px-2 py-4">{{ $book->name }}</td>
                                <td class="px-2 py-4">{{ $book->author->nickname }}</td>
                                <td class="px-2 py-4">{{ $book->type }}</td>
                                <td class="px-2 py-4">
                                    <div>
                                        <x-select-input name="genre[]" class="mt-1 block w-full" multiple>
                                            @foreach($book->genres as $genre )
                                            <option value="{{ $genre->id }}" disabled>{{ $genre->name }}</option>
                                            @endforeach
                                        </x-select-input>
                                        <x-input-error class="mt-2" :messages="$errors->get('genre')" />
                                    </div>
                                </td>
                                <td class="px-2 py-4">{{ $book->publish_date }}</td>
                                <td class="px-2 py-4">{{ $book->created_at }}</td>
                                @if( auth()->user()->role == 'admin' || auth()->user()->id == $book->author->user_id)
                                <td class="px-2 py-4 text-center btn-container">
                                    <a href="/book/{{$book->id}}/update" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mx-8 mb-2 rounded">Изменить</a>
                                    <a href="/book/{{$book->id}}/del" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-4 rounded">Удалить</a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
table {
    border-collapse: separate;
    border-spacing: 6px;
}
.btn-container a {
    display: block;
    margin-bottom: 8px;
}
</style>