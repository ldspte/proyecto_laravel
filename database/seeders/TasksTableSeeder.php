<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TasksTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_ES');

        // Obtener IDs de proyectos y usuarios para asignar
        $projectIds = \App\Models\Project::pluck('id')->toArray();
        $userIds = \App\Models\User::pluck('id')->toArray();

        // Crear tareas
        foreach (range(1, 50) as $index) {
            Task::create([
                'title' => $faker->sentence(5),
                'description' => $faker->sentence(8),
                'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),
                'priority' => $faker->randomElement(['low', 'medium', 'high']),
                'estimated_hours' => $faker->randomFloat(2, 1, 40), // Horas estimadas entre 1 y 40
                'actual_hours' => $faker->randomFloat(2, 0, 40), // Horas reales entre 0 y 40
                'due_date' => $faker->date(), // Fecha de vencimiento
                'project_id' => $faker->randomElement($projectIds), // Asignar un proyecto aleatorio
                'assigned_user_id' => $faker->randomElement($userIds) // Asignar un usuario aleatorio
            ]);
        }
    }
}
