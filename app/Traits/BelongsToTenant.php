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
        // 1. Automatic Query Filtering (Global Scope)
        static::addGlobalScope('landlord', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where(
                    $builder->getModel()->getTable() . '.landlord_id',
                    auth()->id()
                );
            }
        });

        // 2. Automatic Attribute Assignment
        static::creating(function ($model) {
            if (auth()->check() && ! $model->landlord_id) {
                $model->landlord_id = auth()->id();
            }
        });
    }
}
