<?php

namespace App\Models;

use App\Enums\UnitStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'landlord_id',
        'property_id',
        'name',
        'bedrooms',
        'bathrooms',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => UnitStatus::class,
        ];
    }

    /**
     * Relationship: A unit belongs to a property.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
