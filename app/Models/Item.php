<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'condition',
        'item_type',
        'image_url',
        'views',
        'wishlist_count',
        'rating',
        'seller_rating',
        'status',
        'posted_at',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that posted this item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get active items only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Get items by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get items by type (Barter or Donation)
     */
    public function scopeByType($query, $type)
    {
        return $query->where('item_type', $type);
    }

    /**
     * Get items by condition
     */
    public function scopeByCondition($query, $condition)
    {
        return $query->where('condition', $condition);
    }

    /**
     * Get items sorted by rating
     */
    public function scopeHighestRated($query)
    {
        return $query->orderBy('seller_rating', 'desc');
    }

    /**
     * Get most recently posted items
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('posted_at', 'desc');
    }

    /**
     * Get most viewed items
     */
    public function scopeMostViewed($query)
    {
        return $query->orderBy('views', 'desc');
    }

    /**
     * Get users who wishlisted this item
     */
    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get reviews for this item
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
