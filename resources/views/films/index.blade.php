<x-app-layout>
    <x-slot name="header">
        <div class="flex align-middle justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight me-6">
                Films
            </h2>

            @auth
                @if (Auth::user()->is_admin)
                    <div>
                        <a href="{{ route('films.create') }}">
                            <x-primary-button>Créer un film</x-primary-button>
                        </a>
                    </div>
                @endif
            @endauth

        </div>

    </x-slot>
    <section class="max-w-7xl mx-auto rounded-lg mt-6 ">
        @if ($films->isEmpty())
            <p class="text-center text-gray-500">Aucun film trouvé.</p>
        @else
            @foreach ($films as $film)
                <div>
                    <a href="{{ route('films.show', $film->id) }}">
                        <div class="bg-white shadow-md rounded-lg w-1/3 p-6 mb-4 mt-2">
                            <h3 class="text-xl font-semibold mb-2">{{ $film->title }}</h3>
                            <p class="text-gray-600">Année de sortie : {{ $film->release_year }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </section>



</x-app-layout>
