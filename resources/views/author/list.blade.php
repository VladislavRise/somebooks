<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Список авторов
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <table class="">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left">Псевдоним</th>
                                <th class="px-6 py-3 text-left">Имя</th>
                                <th class="px-6 py-3 text-left">Д.Р.</th>
                                <th class="px-6 py-3 text-left">Количество книг</th>
                                <th class="px-6 py-3 text-center">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($authors as $author)
                            <tr>
                                <td class="px-6 py-4">{{ $author->nickname }}</td>
                                <td class="px-6 py-4">{{ $author->full_name }}</td>
                                <td class="px-6 py-4">{{ $author->date_birth }}</td>
                                <td class="px-6 py-4">{{ $author->books()->count() }}</td>
                                @if( auth()->user()->role == 'admin' || auth()->user()->id == $author->user_id)
                                <td class="px-6 py-4 text-center">
                                    <a href="/authors/{{$author->id}}/update" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mx-8 rounded">Изменить</a>
                                    <a href="/authors/{{$author->id}}/del" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-4 rounded">Удалить</a>
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
        border-spacing: 20px; /* Установите желаемое расстояние между ячейками */
    }
</style>