<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;
use App\Enums\MaritalStatus;

#[Fillable(['name',
            'email',
            'password',
            'role',
            'landlord_id',
            'nationality',
            'profession',
            'marital_status',
            'rg',
            'document_number',
            'phone',
            'address',
            'spouse_name',
            'spouse_document',
            'plan_tier',
            'mp_subscription_id',
            'plan_expires_at',
            ])]
#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isLandlord(): bool
    {
        return $this->role === UserRole::Landlord;
    }

    public function isTenant(): bool
    {
        return $this->role === UserRole::Tenant;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'landlord_id',
            'marital_status' => MaritalStatus::class,
            'plan_tier' => \App\Enums\PlanTier::class, // Cast to Enum
            'plan_expires_at' => 'datetime',
        ];
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'landlord_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'landlord_id');
    }
}
