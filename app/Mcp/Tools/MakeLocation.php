<?php

namespace App\Mcp\Tools;

use App\Models\Location;

use Illuminate\Contracts\JsonSchema\JsonSchema;

use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('make-location')]
#[Description('Cree une location pour un film. Accepte name ou location_name, puis utilise automatiquement MCPuser.')]
class MakeLocation extends Tool
{
    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'film_id' => ['required', 'integer', 'exists:films,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'location_name' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $name = $validated['name'] ?? $validated['location_name'] ?? null;

        if (! is_string($name) || trim($name) === '') {
            return Response::error('Either name or location_name must be provided.');
        }


        $location = Location::create([
            'film_id' => $validated['film_id'],
            'user_id' => 999,
            'name' => $name,
            'city' => $validated['city'],
            'country' => $validated['country'],
            'description' => $validated['description'],
        ]);

        return Response::json([
            'message' => 'Location created successfully.',
            'location' => $location,
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
            'film_id' => $schema->integer()->required()->description('ID du film.'),
            'name' => $schema->string()->description('Nom du lieu de tournage.'),
            'location_name' => $schema->string()->description('Nom de la location.'),
            'city' => $schema->string()->required()->description('Ville.'),
            'country' => $schema->string()->required()->description('Pays.'),
            'description' => $schema->string()->required()->description('Description du lieu.'),
        ];
    }
}
