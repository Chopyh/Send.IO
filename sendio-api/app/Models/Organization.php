<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'website',
    ];

    public function organizationUsers()
    {
        return $this->hasMany(OrganizationUser::class);
    }

    public function billingProfile()
    {
        return $this->hasOne(BillingProfile::class);
    }
}
