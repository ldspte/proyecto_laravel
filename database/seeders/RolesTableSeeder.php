<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Administrator with full system access'
            ],
            [
                'name' => 'Project Manager',
                'description' => 'Manages projects and team assignments'
            ],
            [
                'name' => 'Developer',
                'description' => 'Developer working on assigned tasks'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
