<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'google_email',
        'avatar_url',
        'bio',
        'phone',
        'rating',
        'trades_count',
        'role',
    ];

    public static function nameFromEmail(string $email): string
    {
        $localPart = explode('@', $email, 2)[0];
        $name = ucwords(str_replace(['.', '_', '-'], ' ', $localPart));

        // Student-number emails cannot reveal a person's name.
        return preg_match('/^\d+$/', $localPart) ? 'UB Member' : $name;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the items this user has posted
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function donationClaims()
    {
        return $this->hasMany(DonationClaim::class, 'claimant_id');
    }

    /**
     * Get this user's wishlist
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get reviews written by this user
     */
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * Get reviews about this user
     */
    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    /**
     * Get reviews received (alias for API)
     */
    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    /**
     * Get trades initiated by this user
     */
    public function initiatedTrades()
    {
        return $this->hasMany(Trade::class, 'initiator_id');
    }

    /**
     * Get trades received by this user
     */
    public function receivedTrades()
    {
        return $this->hasMany(Trade::class, 'receiver_id');
    }

    /**
     * Get average rating for this user
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviewsReceived()->avg('rating') ?? 0;
    }

    /**
     * Get total review count
     */
    public function getReviewCountAttribute()
    {
        return $this->reviewsReceived()->count();
    }

    /**
     * Check if user is suspended
     */
    public function isSuspended(): bool
    {
        return $this->role === 'suspended';
    }

    /**
     * Get notifications for this user
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Unread notification count
     */
    public function unreadNotificationsCount(): int
    {
        return $this->notifications()->whereNull('read_at')->count();
    }
}
