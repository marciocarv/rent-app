<?php

namespace App\Models;

use App\Enums\ContractStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'landlord_id',
        'unit_id',
        'start_date',
        'end_date',
        'monthly_rent',
        'due_day',
        'document_body',
        'document_hash',
        'status',
        'landlord_signed_at',
        'landlord_sign_ip',
        'tenant_signed_at',
        'tenant_sign_ip'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'due_day' => 'integer',
            'status' => ContractStatus::class,
            'payment_method' => PaymentMethod::class,
            'landlord_signed_at' => 'datetime',
            'tenant_signed_at' => 'datetime',
        ];
    }

    public function landlord(): BelongsTo
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
