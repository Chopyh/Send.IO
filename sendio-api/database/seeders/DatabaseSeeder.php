<?php

namespace Database\Seeders;

use App\Models\BillingProfile;
use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a main user ("You")
        $mainUser = User::factory()->create([
            'name' => 'Admin Principal',
            'email' => 'admin@miempresa.com',
        ]);

        // 2. Create an organization for this user
        $organization = Organization::factory()->create([
            'name' => 'Mi Empresa SaaS',
            'slug' => 'mi-empresa-saas',
        ]);

        // 3. Link the user to the organization as 'owner'
        OrganizationUser::factory()->create([
            'user_id' => $mainUser->id,
            'organization_id' => $organization->id,
            'role' => 'owner',
            'onboarding_completed' => true,
        ]);

        // 4. Create their billing profile
        BillingProfile::factory()->create([
            'organization_id' => $organization->id,
            'billing_email' => 'facturacion@miempresa.com',
        ]);

        // 5. Link a test social account
        SocialAccount::factory()->create([
            'user_id' => $mainUser->id,
            'provider' => 'github',
        ]);

        // EXTRA: Generate 10 additional random users with their own organizations
        User::factory(10)->create()->each(function ($user) {
            $org = Organization::factory()->create();

            OrganizationUser::factory()->create([
                'user_id' => $user->id,
                'organization_id' => $org->id,
                'role' => 'owner',
            ]);

            BillingProfile::factory()->create([
                'organization_id' => $org->id,
            ]);
        });
    }
}
