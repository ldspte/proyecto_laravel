<?php

namespace Database\Seeders;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProjectsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_ES');
        $statuses = ['planning', 'in_progress', 'on_hold', 'completed'];
        
        // Proyectos principales
        Project::create([
            'name' => 'Sistema de Gestión de Proyectos',
            'description' => 'Desarrollo de plataforma interna para gestión de proyectos',
            'client_name' => 'Departamento Interno',
            'start_date' => Carbon::now()->subMonths(2),
            'end_date' => Carbon::now()->addMonths(4), 
            'budget' => 25000.00,
            'status' => 'in_progress',
            'team_id' => 3 // Equipo Fullstack
        ]);

        Project::create([
            'name' => 'Aplicación Móvil',
            'description' => 'Desarrollo de app para clientes externos',
            'client_name' => 'Clientes S.A.',
            'start_date' => Carbon::now()->subMonth(),
            'end_date' => Carbon::now()->addMonths(3),
            'budget' => 18000.00,
            'status' => 'planning',
            'team_id' => 1 // Equipo Frontend
        ]);

        // Proyectos adicionales
        for ($i = 3; $i <= 8; $i++) {
            $start = $faker->dateTimeBetween('-3 months', '+1 month');
            
            Project::create([
                'name' => $faker->catchPhrase,
                'description' => $faker->realText(200),
                'client_name' => $faker->company,
                'start_date' => $start,
                'end_date' => $faker->dateTimeBetween($start, '+6 months'),
                'budget' => $faker->randomFloat(2, 5000, 30000),
                'status' => $faker->randomElement($statuses),
                'team_id' => $faker->numberBetween(1, 3)
            ]);
        }
    }
}
