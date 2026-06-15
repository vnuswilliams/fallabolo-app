<?php

namespace App\Mcp\Tools;

use App\Models\RecruiterProfile;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Tool;

#[Name('list_recruiters')]
#[Description('List all recruiters to find the correct recruiter_profile_id.')]
class ListRecruiters extends Tool
{
    /**
     * Handle the tool execution.
     */
    public function handle(): mixed
    {
        return RecruiterProfile::all()->map(fn ($r) => [
            'id' => $r->id,
            'company_name' => $r->company_name,
            'city' => $r->city,
        ]);
    }
}
