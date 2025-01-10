<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3), // Vygeneruje vetu s 3 slovami
            'description' => $this->faker->paragraph(2), // Vygeneruje 2 odstavce
        ];
    }
}
