<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Опубликуйте книгу
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                <section>
                    @if(auth()->user()->author)
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Опубликуйте книгу
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Введите название книги, жанр, тип и дату публикации.
                        </p>
                    </header>
                    <form method="post" action="{{ route('book.add') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Название')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', '')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Описание')" />
                            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                        <div>
                            <x-input-label for="genre" value="Жанр" />
                            <x-select-input name="genre[]" class="mt-1 block w-full" multiple>
                                @foreach($genres as $genre )
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('genre')" />
                        </div>
                        <div>
                            <x-input-label for="type" value="Тип издания" />
                            <x-select-input name="type" class="mt-1 block w-full">
                                <option value="Графическое издание">Графическое издание</option>
                                <option value="Цифровое издание">Цифровое издание</option>
                                <option value="Печатное издание">Печатное издание</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>
                        <div>
                            <x-input-label for="publish_date" :value="__('Дата публикации')" />
                            <x-text-input id="publish_date" name="publish_date" type="date" class="mt-1 block w-full" :value="old('publish_date', '')" />
                            <x-input-error class="mt-2" :messages="$errors->get('publish_date')" />
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
                    @else
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Сначала заполните данные автора в <a href="/profile" class="text-gray-500">Профиле</a>
                    </h2>
                    @endif
                </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
