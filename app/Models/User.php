<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'display_name', // Added per your requirement
        'email',
        'password',
        'profile_photo_path', // Added per your requirement
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationship: A user has many tweets
    public function tweets()
    {
        return $this->hasMany(Tweet::class)->latest();
    }

    // Relationship: A user has many likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}