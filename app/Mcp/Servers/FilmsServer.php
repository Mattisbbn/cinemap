<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\GetLocationsForFilm;
use App\Mcp\Tools\Makefilm;
use App\Mcp\Tools\ListFilms;
use App\Mcp\Tools\MakeLocation;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('Films Server')]
#[Version('0.0.1')]
#[Instructions('Instructions describing how to use the server and its features.')]
class FilmsServer extends Server
{
    protected array $tools = [
        ListFilms::class,
        GetLocationsForFilm::class,
        Makefilm::class,
        MakeLocation::class
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
