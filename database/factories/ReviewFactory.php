<?php

namespace Database\Factories;

use App\Enum\ReviewStatus;
use App\Models\Picture;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->getKey(),
            'email' => $this->faker->unique()->safeEmail(),
            'subject' => implode(' ', $this->faker->words),
            'message' => implode(' ', $this->faker->words),
            'status' => ReviewStatus::WaitingForApproval->value,
            'score' => rand(1, 5),
            'picture_id'  => Picture::factory()->create()->getKey()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function(array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
