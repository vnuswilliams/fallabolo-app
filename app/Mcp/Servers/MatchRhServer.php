<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\ListJobOffers;
use App\Mcp\Tools\CreateJobOffer;
use App\Mcp\Tools\ListRecruiters;
use App\Mcp\Tools\GetJobOfferDetails;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('matchrh')]
#[Version('1.0.0')]
#[Instructions('This server provides tools to interact with the MatchRH job board. You can list job offers, list recruiters, and create new job offers.')]
class MatchRhServer extends Server
{
    protected array $tools = [
        ListJobOffers::class,
        CreateJobOffer::class,
        ListRecruiters::class,
        GetJobOfferDetails::class,
    ];

    protected array $resources = [];

    protected array $prompts = [];
}
