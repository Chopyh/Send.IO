<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingProfile extends Model
{
    /** @use HasFactory<\Database\Factories\BillingProfileFactory> */
    use HasUuids, HasFactory;

    protected $fillable = [
        'organization_id',
        'type',
        'legal_name',
        'tax_id',
        'billing_email',
        'billing_phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
