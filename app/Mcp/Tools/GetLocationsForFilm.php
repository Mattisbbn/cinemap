<?php

namespace App\Mcp\Tools;

use App\Models\Film;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('get_locations_for_film')]
#[Description('Retourne les locations associees a un film.')]
class GetLocationsForFilm extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'film_id' => ['required', 'integer', 'exists:films,id'],
        ]);

        $film = Film::query()
            ->with(['locations' => function ($query) {
                $query->select(['id', 'film_id', 'name', 'city', 'country', 'description', 'upvotes_count']);
            }])
            ->findOrFail($validated['film_id']);

        return Response::json([
            'film' => [
                'id' => $film->id,
                'title' => $film->title,
                'release_year' => $film->release_year,
            ],
            'locations' => $film->locations,
            'count' => $film->locations->count(),
        ]);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'film_id' => $schema->integer()->required()->min(1)->description('ID du film.'),
        ];
    }
}
