<?php

namespace Database\Factories;

use App\Models\Course;
use Database\Factories\helpers\FactoryHelpers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->word(),
            "thumbnail" => $this->faker->imageUrl(),
            "video" => [],
            "course_id" => FactoryHelpers::getRandomTableId(Course::class),
            "duration" => $this->faker->randomDigit()
        ];
    }
}
