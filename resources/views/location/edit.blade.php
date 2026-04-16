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
        <form action="{{ route('locations.update', $location->id) }}" method="POST" class="mt-6">
            @csrf
            @method('PUT')
            <div>
                <x-input-label>Nom</x-input-label>
                <x-text-input name="name" value="{{ $location->name }}"></x-text-input>

                <x-input-label>Film lié</x-input-label>
                <select name="film_id" class="rounded">
                    @foreach ($films as $film)
                        <option value="{{ $film->id }}" {{ $location->film_id == $film->id ? 'selected' : '' }}>
                            {{ $film->title }}
                        </option>
                    @endforeach
                </select>

                <x-input-label>Ville</x-input-label>
                <x-text-input name="city" value="{{ $location->city }}"></x-text-input>

                <x-input-label>Pays</x-input-label>
                <x-text-input name="country" value="{{ $location->country }}"></x-text-input>

                <x-input-label>Description</x-input-label>
                <textarea name="description" cols="40" rows="3">{{ $location->description }}</textarea>
            </div>
            <x-primary-button class="mt-4">Modifier</x-primary-button>
        </form>


    </section>

</x-app-layout>
