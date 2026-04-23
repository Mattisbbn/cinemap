<?php

use App\Mcp\Servers\FilmsServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::local('films', FilmsServer::class);
Mcp::web('/mcp/films', FilmsServer::class);
