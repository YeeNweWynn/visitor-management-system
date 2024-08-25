<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CheckIn>
 */
class CheckInFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'checked_in_at' => now(),
            'checked_out_at' => null,
            'type' => 'walk_in',
            'vehicle_number' => null,
            'purpose_of_visit' => 'meeting'
        ];
    }

    /**
     * Indicate that the check-in has been checked out.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function checkedOut()
    {
        return $this->state(function (array $attributes) {
            return [
                'checked_out_at' => now(),
            ];
        });
    }
}
