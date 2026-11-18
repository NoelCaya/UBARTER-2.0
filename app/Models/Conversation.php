<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = ['user_one_id', 'user_two_id', 'last_message_at'];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Get the other participant in this conversation
     */
    public function otherUser(int $currentUserId): User
    {
        return $this->user_one_id === $currentUserId
            ? $this->userTwo
            : $this->userOne;
    }

    /**
     * Find or create a conversation between two users
     */
    public static function findOrCreateBetween(int $userOneId, int $userTwoId): self
    {
        // Always store with smaller ID as user_one for consistency
        [$a, $b] = $userOneId < $userTwoId
            ? [$userOneId, $userTwoId]
            : [$userTwoId, $userOneId];

        return self::firstOrCreate(
            ['user_one_id' => $a, 'user_two_id' => $b]
        );
    }

    /**
     * Count unread messages for a given user
     */
    public function unreadCountFor(int $userId): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }
}
