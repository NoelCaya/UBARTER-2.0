<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'initiator_id',
        'receiver_id',
        'initiator_item_id',
        'receiver_item_id',
        'status',
        'message',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who initiated the trade
     */
    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    /**
     * Get the user who receives the trade request
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get the item offered by the initiator
     */
    public function initiatorItem()
    {
        return $this->belongsTo(Item::class, 'initiator_item_id');
    }

    /**
     * Get the item offered by the receiver
     */
    public function receiverItem()
    {
        return $this->belongsTo(Item::class, 'receiver_item_id');
    }

    /**
     * Get reviews for this trade
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
