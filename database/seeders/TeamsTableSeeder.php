<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    public function run()
    {
        // Obtener IDs de usuarios con rol de project_manager o admin para ser líderes
        $leaders = User::whereIn('role_id', [2, 1])
                     ->pluck('id')
                     ->toArray();

        $teams = [
            [
                'name' => 'Equipo Alpha',
                'description' => 'Equipo especializado en desarrollo frontend con React',
                'budget' => '75000',
                'team_leader_id' => $leaders[0] ?? null
            ],
            [
                'name' => 'Equipo Beta', 
                'description' => 'Equipo backend enfocado en APIs y microservicios',
                'budget' => '68000',
                'team_leader_id' => $leaders[1] ?? null
            ],
            [
                'name' => 'Equipo Gamma',
                'description' => 'Equipo fullstack para desarrollo rápido',
                'budget' => '92000',
                'team_leader_id' => $leaders[2] ?? null
            ]
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }

        // Si no hay suficientes líderes, crear equipos adicionales con líder null
        if (count($leaders) < 3) {
            Team::create([
                'name' => 'Equipo Delta',
                'description' => 'Equipo de soporte técnico',
                'budget' => '45000',
                'team_leader_id' => null
            ]);
        }
    }
}
