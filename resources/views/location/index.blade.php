<x-app-layout>
    <x-slot name="header">
        <div class="flex align-middle justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight me-6">
                Localisations
            </h2>
            <div>
                <a href="{{ route('locations.create') }}">
                    <x-primary-button>Créer une localisation</x-primary-button>
                </a>
            </div>

        </div>

    </x-slot>
    <section class="max-w-7xl mx-auto rounded-lg mt-6 ">
        @if ($locations->isEmpty())
            <p class="text-center text-gray-500">Aucune localisation trouvée.</p>
        @else
            @foreach ($locations as $location)
                <div>
                    <a href="{{ route('locations.show', $location->id) }}">
                        <div class="bg-white shadow-md rounded-lg w-1/3 p-6 mb-4 mt-2">
                            <h3 class="text-xl font-semibold mb-2">{{ $location->name }}</h3>
                            <p class="text-gray-600">Film lié : {{ $location->film->title }}</p>
                            <p class="text-gray-600">Ville: {{ $location->city }}</p>
                            <p class="text-gray-600">Pays: {{ $location->country }}</p>
                            <p class="text-gray-600">Description: {{ $location->description }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </section>



</x-app-layout>
