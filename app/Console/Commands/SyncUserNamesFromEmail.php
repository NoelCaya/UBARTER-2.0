<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SyncUserNamesFromEmail extends Command
{
    protected $signature   = 'users:sync-names {--force : Skip confirmation prompts}';
    protected $description = 'Find users whose name is a student number and prompt to fix them';

    public function handle(): int
    {
        // Find users whose name looks like a student number (all digits, or digits@domain)
        $users = User::where('role', '!=', 'admin')
            ->get()
            ->filter(fn($u) => preg_match('/^\d+$/', trim($u->name)));

        if ($users->isEmpty()) {
            $this->info('No users with student-number names found. All good!');
            return Command::SUCCESS;
        }

        $this->warn("Found {$users->count()} user(s) with student-number names:");
        $updated = 0;

        foreach ($users as $user) {
            $this->line("  ID {$user->id} | Name: {$user->name} | Email: {$user->email}");

            if ($this->option('force')) {
                // In force mode, leave name unchanged but flag it
                $this->line("    → Skipped (use interactive mode to set real names)");
                continue;
            }

            $newName = $this->ask("    Enter the real name for {$user->email} (leave blank to skip)");

            if (!empty(trim($newName))) {
                $user->name = trim($newName);
                $user->saveQuietly();
                $this->info("    ✓ Updated to: {$user->name}");
                $updated++;
            } else {
                $this->line("    → Skipped");
            }
        }

        $this->info("\nDone. Updated {$updated} of {$users->count()} users.");
        return Command::SUCCESS;
    }
}
