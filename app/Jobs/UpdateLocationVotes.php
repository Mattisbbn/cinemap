<?php

namespace App\Jobs;

use App\Models\Location;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateLocationVotes implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $locationId) {}

    public function handle(): void
    {
        $location = Location::find($this->locationId);

        if (! $location instanceof Location) {
            return;
        }

        $votesCount = $location->location_votes()->count();

        $location->update([
            'upvotes_count' => $votesCount,
        ]);
    }
}
