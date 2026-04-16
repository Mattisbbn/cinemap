<x-app-layout>
    <x-slot name="header">
        <div class="flex align-middle justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight me-6">
                Films
            </h2>
        </div>
    </x-slot>


    <section class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-white shadow rounded mt-6">
        <h1 class="text-center text-xl font-semibold">Modifier un film</h1>
        <form action="{{ route('films.update', $film->id) }}" method="POST" class="mt-6">
            @csrf
            @method('PUT')
            <div>
                <x-input-label>Titre</x-input-label>
                <x-text-input name="title" value="{{ $film->title }}"></x-text-input>
                <x-input-label>Année de sortie</x-input-label>
                <x-text-input name="release_year" value="{{ $film->release_year }}"></x-text-input>
            </div>
            <x-primary-button class="mt-4">Modifier</x-primary-button>
        </form>


    </section>

</x-app-layout>
