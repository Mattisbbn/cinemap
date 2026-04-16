<x-app-layout>
    <x-slot name="header">
        <div class="flex align-middle justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight me-6">
                Films : {{ $film->title }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('films.edit', $film->id) }}">
                    <x-primary-button>Modifier le film</x-primary-button>
                </a>

                <form action="{{ route('films.destroy', $film->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-danger-button>Supprimer le film</x-danger-button>
                </form>

            </div>

        </div>

    </x-slot>



    <section class="max-w-7xl mx-auto sm:p-6 lg:p-8 bg-white shadow rounded-lg mt-6">
        <h1 class="text-2xl font-bold mb-4">{{ $film->title }}</h1>
        <p class="text-gray-600 mb-2">Année de sortie : {{ $film->release_year }}</p>


    </section>

</x-app-layout>
