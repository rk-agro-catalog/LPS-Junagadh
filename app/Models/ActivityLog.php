<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Associated Admin User if applicable.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for filtering by user type.
     */
    public function scopeUserType($query, ?string $type)
    {
        if ($type && $type !== 'all') {
            return $query->where('user_type', $type);
        }

        return $query;
    }

    /**
     * Scope for filtering by device type.
     */
    public function scopeDeviceType($query, ?string $type)
    {
        if ($type && $type !== 'all') {
            return $query->where('device_type', $type);
        }

        return $query;
    }
}
