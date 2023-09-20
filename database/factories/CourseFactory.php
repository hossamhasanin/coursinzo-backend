<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\helpers\FactoryHelpers;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{

    protected $model = Course::class;

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
            "user_id" => FactoryHelpers::getRandomTableId(User::class),
            "category_id" => FactoryHelpers::getRandomTableId(Category::class),
            "price" => $this->faker->randomDigit()
        ];
    }
}
