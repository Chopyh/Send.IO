<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizationUser>
 */
class OrganizationUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'user_id' => User::factory(),
        'organization_id' => Organization::factory(),
        'role' => $this->faker->randomElement(['owner', 'admin', 'member']),
        'onboarding_completed' => $this->faker->boolean(80), // 80% de prob de ser true
        'checklist_dismissed' => $this->faker->boolean(50),
    ];
    }
}
