<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationUser extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'organization_user';

    protected $fillable = [
        'organization_id',
        'user_id',
        'role',
        'onboarding_completed',
        'checklist_dismissed'
    ];

    protected function casts(): array
    {
        return [
            'onboarding_completed' => 'boolean',
            'checklist_dismissed' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
