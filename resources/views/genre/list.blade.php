<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Жанры
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-xl">
                        <section>
                            <h2 class="text-lg font-medium text-gray-900">
                                Добавьте жанр
                            </h2>
  
                            <form method="post" action="{{ route('genres.add') }}" class="mt-6 space-y-6">
                                @csrf

                                <div>
                                    <x-input-label for="name" :value="__('Название')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="Введите название жанра." required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                                    @if (session('status') === 'Done')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600"
                                        >{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </section>
                    </div>
                    <br>
                    Список жанров:
                    <table class="">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left">Жанр</th>
                                @if(auth()->user()->role == 'admin')
                                <th class="px-6 py-3 text-center">Действия</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($genres as $genre)
                            <tr>
                                <td class="px-6 py-4">{{ $genre->name }}</td>
                                @if(auth()->user()->role == 'admin')
                                <td class="px-6 py-4 text-center">
                                    <a href="/genres/{{$genre->id}}/update" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mx-8 rounded">Изменить</a>
                                    <a href="/genres/{{$genre->id}}/del" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-4 rounded">Удалить</a>
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