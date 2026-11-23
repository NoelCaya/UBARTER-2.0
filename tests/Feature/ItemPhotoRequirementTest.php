<?php

use App\Models\User;

test('new items require a photo', function () {
    $this->actingAs(User::factory()->create())
        ->from(route('items.create'))
        ->post(route('items.store'), [
            'title' => 'Calculus Textbook',
            'description' => 'A used textbook.',
            'category' => 'Books & Textbooks',
            'condition' => 'Used',
            'item_type' => 'Barter',
        ])
        ->assertRedirect(route('items.create'))
        ->assertSessionHasErrors('image');
});
