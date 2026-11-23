<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PromoteCesClientAccountToAdmin extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'ces@ub.edu.ph')->firstOrFail();
        $user->update(['role' => 'admin']);
    }
}
