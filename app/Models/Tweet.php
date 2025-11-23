<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'is_edited',
    ];

    // Relationship: A tweet belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A tweet has many likes
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    // Helper: Check if the current logged-in user liked this tweet
    public function isLikedBy(User $user): bool
    {
        return $this->likes->contains('user_id', $user->id);
    }
}