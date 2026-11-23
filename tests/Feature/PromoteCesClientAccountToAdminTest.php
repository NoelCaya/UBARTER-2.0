<?php

use App\Models\User;
use Database\Seeders\PromoteCesClientAccountToAdmin;
use Illuminate\Support\Facades\Hash;

test('CES client account is promoted without changing its credentials', function () {
    $password = Hash::make('existing-password');
    $user = User::factory()->create([
        'name' => 'CES Client',
        'email' => 'ces@ub.edu.ph',
        'password' => $password,
        'role' => 'user',
    ]);

    app(PromoteCesClientAccountToAdmin::class)->run();

    expect($user->fresh()->role)->toBe('admin')
        ->and($user->fresh()->name)->toBe('CES Client')
        ->and(Hash::check('existing-password', $user->fresh()->password))->toBeTrue();
});
