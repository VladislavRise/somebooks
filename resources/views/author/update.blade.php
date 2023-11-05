<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Отредактируйте данные автора
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Отредактируйте данные автора
                        </h2>
                    </header>
                    <form method="post" action="{{ route('author.update', ['id' => $author->id]) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="nickname" :value="__('Псевдоним')" />
                            <x-text-input id="nickname" name="nickname" type="text" class="mt-1 block w-full" :value="old('nickname', optional($author)->nickname)" autocomplete="nickname" />
                            <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
                        </div>
                        <div>
                            <x-input-label for="full_name" :value="__('Полное имя')" />
                            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', optional($author)->full_name)" autocomplete="full_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
                        </div>
                        <div>
                            <x-input-label for="date_birth" :value="__('дата рождения')" />
                            <x-text-input id="date_birth" name="date_birth" type="date" class="mt-1 block w-full" :value="old('date_birth', optional($author)->date_birth)" autocomplete="date_birth" />
                            <x-input-error class="mt-2" :messages="$errors->get('date_birth')" />
                        </div>
                        <div>
                            <x-input-label for="biography" :value="__('Биография')" />
                            <x-text-input id="biography" name="biography" type="text" class="mt-1 block w-full" :value="old('biography', optional($author)->biography)" autocomplete="biography" />
                            <x-input-error class="mt-2" :messages="$errors->get('biography')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
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