<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bhumidan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'sq_yards' => 'integer',
        'rate_per_yard' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /**
     * Scope for verified donations
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope for featured donors
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
