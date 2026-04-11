<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_available'  => 'boolean',
        'has_pool'      => 'boolean',
        'has_gym'       => 'boolean',
        'has_parking'   => 'boolean',
        'available_from'=> 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    // Users who wishlisted this property
    public function wishedBy()
    {
        return $this->belongsToMany(User::class, 'property_user')
                    ->withPivot('added_at');
    }
}
