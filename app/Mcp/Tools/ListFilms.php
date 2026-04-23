<?php

namespace App\Mcp\Tools;

use App\Models\Film;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('list_films')]
#[Description("Liste les films disponibles dans l'application.")]
class ListFilms extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $films = Film::query()
            ->select(['id', 'title', 'release_year'])
            ->orderBy('title')
            ->get();

        return Response::json([
            'films' => $films,
            'count' => $films->count(),
        ]);
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
