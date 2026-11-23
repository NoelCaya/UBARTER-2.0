<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SyncUserNamesFromEmail extends Command
{
    protected $signature   = 'users:sync-names';
    protected $description = 'Reset all user names to be derived from their UBmail address';

    public function handle(): int
    {
        $users   = User::all();
        $updated = 0;

        foreach ($users as $user) {
            if (!$user->email) {
                continue;
            }
            $synced = User::nameFromEmail($user->email);

            if ($user->name !== $synced) {
                $user->name = $synced;
                $user->saveQuietly();
                $updated++;
            }
        }

        $this->info("Done. Updated {$updated} of {$users->count()} users.");
        return Command::SUCCESS;
    }
}
