<x-app-layout>
    <x-slot name="header">
        <div class="flex align-middle justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight me-6">
                Localisation : {{ $location->name }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('locations.edit', $location->id) }}">
                    <x-primary-button>Modifier la localisation</x-primary-button>
                </a>


                <form action="{{ route('locations.destroy', $location->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-danger-button>Supprimer la localisation</x-danger-button>
                </form>


            </div>

        </div>

    </x-slot>

    <section class="max-w-7xl mx-auto sm:p-6 lg:p-8 bg-white shadow rounded-lg mt-6">
        <h1 class="text-2xl font-bold mb-4">{{ $location->name }}</h1>
        <p class="text-gray-600 mb-2">Film lié : {{ $location->film->title }}</p>
        <p class="text-gray-600 mb-2">Ville : {{ $location->city }}</p>
        <p class="text-gray-600 mb-2">Pays : {{ $location->country }}</p>
        <p class="text-gray-600 mb-2">Description : {{ $location->description }}</p>
        <p class="text-gray-600 mb-2">Créé par : {{ $location->user->name }}</p>
        <p class="text-gray-600 mb-2">Votes : {{ $location->upvotes_count }}</p>
    </section>

</x-app-layout>
