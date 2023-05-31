<?php


namespace Database\Factories;

use App\Enum\PictureStatus;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PictureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $image = $this->faker->image(category: 'cats');
        $imageFile = new File($image);

        return [
            'user_id' => User::factory()->create()->getKey(),
            'description' => implode(' ', $this->faker->words),
            'title' => implode(' ', $this->faker->words),
            'status' => PictureStatus::Draft->value,
            'file_path' => Storage::disk('public')->putFile('images', $imageFile),

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
