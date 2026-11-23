<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationClaim extends Model
{
    protected $fillable = ['item_id', 'claimant_id', 'message', 'status'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function claimant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimant_id');
    }
}
