<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['reviewer_id', 'reviewee_id', 'reviewed_user_id', 'item_id', 'trade_id', 'rating', 'comment'];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }
}
