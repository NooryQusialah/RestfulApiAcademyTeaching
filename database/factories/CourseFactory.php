<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'teacher_id' => null, // This will be set when associating with a Teacher
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'credits' => $this->faker->numberBetween(1, 5),
        ];
    }
}
