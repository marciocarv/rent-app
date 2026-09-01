<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'value' => 'decimal:2',
        ];
    }

    // Checks if the coupon is still valid to be used
    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    // Applies the math based on if it is a % or a fixed R$ discount
    public function calculateDiscount(float $originalPrice): float
    {
        if ($this->type === 'percentage') {
            $discounted = $originalPrice - ($originalPrice * ($this->value / 100));
        } else {
            $discounted = $originalPrice - $this->value;
        }

        // Prevent negative prices
        return max(0, $discounted);
    }
}
