<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    /**
     * Boot the BelongsToTenant trait for the model.
     */
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('landlord_scope', function (Builder $builder) {
            if (auth()->check()) {
                $landlordId = auth()->user()->isTenant()
                    ? auth()->user()->landlord_id
                    : auth()->id();

                $builder->where('landlord_id', $landlordId);
            }
        });
    }
}
