<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Location;

#[Signature('app:purge-locations')]
#[Description('Command description')]
class PurgeLocations extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        Location::where('created_at', '<', now()->subDays(14))->where('upvotes_count', '<', 2)->delete();

        $this->info('Localisations purgées.');

        return Command::SUCCESS;
    }
}
