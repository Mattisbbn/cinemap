<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;
use App\Models\Film;

#[Name('make_film')]
#[Description("Cree un film avec un titre et une annee de sortie.")]
class Makefilm extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'release_year' => ['required', 'integer', 'min:1888', 'max:' . ((int) date('Y') + 1)],
        ]);

        $film = Film::create([
            'title' => $validated['title'],
            'release_year' => $validated['release_year'],
        ]);

        return Response::json([
            'message' => 'Film cree avec succes.',
            'film' => [
                'id' => $film->id,
                'title' => $film->title,
                'release_year' => $film->release_year,
            ],
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
            'title' => $schema->string()->required()->description('Titre du film.'),
            'release_year' => $schema->integer()->required()->description('Annee de sortie.')->min(1888)->max((int) date('Y') + 1),
        ];
    }
}
