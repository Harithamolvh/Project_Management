<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $modal = Task::class;
    public function definition(): array
    {
        return [
            'project_id' => Project::inRandomOrder()->first()->id,
            'task_name' => 'Task ' . $this->faker->unique()->numberBetween(1, 500),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}
