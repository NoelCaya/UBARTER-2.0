<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ces.admin@ub.edu.ph'],
            [
                'name'              => 'Community Extension Services ADMIN',
                'email'             => 'ces.admin@ub.edu.ph',
                'password'          => Hash::make('CESAdmin@2026'),
                'role'              => 'admin',
                'email_verified_at' => now(),
                'rating'            => 5.0,
                'trades_count'      => 0,
            ]
        );
    }
}
