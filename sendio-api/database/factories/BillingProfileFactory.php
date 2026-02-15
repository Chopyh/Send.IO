<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BillingProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'organization_id' => Organization::factory(),
        'type' => $this->faker->randomElement(['personal', 'business']),
        'legal_name' => $this->faker->company(),
        'tax_id' => $this->faker->numerify('TAX-#########'),
        'billing_email' => $this->faker->companyEmail(),
        'billing_phone' => $this->faker->phoneNumber(),
        'address_line1' => $this->faker->streetAddress(),
        'city' => $this->faker->city(),
        'postal_code' => $this->faker->postcode(),
        'country' => $this->faker->countryCode(), // ISO 3166-1 alpha-2
    ];
    }
}
