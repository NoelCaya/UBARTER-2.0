<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->select(['id', 'email'])->orderBy('id')->chunk(500, function ($users) {
            foreach ($users as $user) {
                if (!$user->email) {
                    continue;
                }

                $localPart = explode('@', $user->email, 2)[0];
                $name = ucwords(str_replace(['.', '_', '-'], ' ', $localPart));

                DB::table('users')->where('id', $user->id)->update(['name' => $name]);
            }
        });
    }

    public function down(): void
    {
        // Existing profile names cannot be recovered after synchronization.
    }
};
