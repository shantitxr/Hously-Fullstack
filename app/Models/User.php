<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'profile_image', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    // Wishlist: N:N via property_user pivot
    public function wishlist()
    {
        return $this->belongsToMany(Property::class, 'property_user')
                    ->withPivot('added_at');
    }

    public function sentInquiries()
    {
        return $this->hasMany(Inquiry::class, 'sender_id');
    }
}