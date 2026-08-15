<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    // This connects our multi-tenancy security trait to this specific model
    use HasFactory, BelongsToTenant;

    // These are the only columns we allow to be mass-assigned via our forms
    protected $fillable = [
        'landlord_id',
        'name',
        'address',
        'type',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'type' => PropertyType::class, // <-- Casts string to Enum
        ];
    }

    /**
     * Relationship: A property belongs to a landlord (User).
     */
    public function landlord(): BelongsTo
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
