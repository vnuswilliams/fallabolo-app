<?php

namespace App\Providers;

use App\Mcp\Servers\MatchRhServer;
use Illuminate\Support\ServiceProvider;
use Laravel\Mcp\Facades\Mcp;

class McpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Mcp::local('matchrh', MatchRhServer::class);
    }
}
