<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Отредактируйте книгу
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Отредактируйте книгу
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Введите название книги, жанр, тип и дату публикации.
                        </p>
                    </header>

                    <form method="post" action="{{ route('book.update', ['id' => $book->id]) }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-text-input name="id" type="hidden" class="mt-1 block w-full" :value="old('id', $book->id)" required />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Название')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $book->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Описание')" />
                            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $book->description)" autocomplete="description" />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>
                        <div>
                            <x-input-label for="genre" value="Жанр" />
                            <x-select-input name="genre[]" class="mt-1 block w-full" multiple>
                                @foreach($genres as $genre )
                                <option value="{{ $genre->id }}" @if(in_array($genre->id, $book->genres->pluck('id')->toArray())) selected @endif>{{ $genre->name }}</option>
                                @endforeach
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('genre')" />
                        </div>
                        <div>
                            <x-input-label for="type" value="Тип издания" />
                            <x-select-input name="type" class="mt-1 block w-full" :value="old('type', $book->type)" autocomplete="type">
                                <option value="Графическое издание" @if($book->type === 'Графическое издание') selected @endif>Графическое издание</option>
                                <option value="Цифровое издание" @if($book->type === 'Цифровое издание') selected @endif>Цифровое издание</option>
                                <option value="Печатное издание" @if($book->type === 'Печатное издание') selected @endif>Печатное издание</option>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>
                        <div>
                            <x-input-label for="publish_date" :value="__('Дата публикации')" />
                            <x-text-input id="publish_date" name="publish_date" type="date" class="mt-1 block w-full" :value="old('publish_date', $book->publish_date)" autocomplete="publish_date" />
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
                </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
