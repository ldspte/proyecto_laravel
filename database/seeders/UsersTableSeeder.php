<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_ES');
        
        // Usuario administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@empresa.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'salary' => 4500.00,
            'hire_date' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Project Managers
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => 'pm'.$i.'@empresa.com',
                'password' => Hash::make('password'),
                'role_id' => 2, 
                'salary' => $faker->randomFloat(2, 3000, 4000),
                'hire_date' => now()->subMonths($i),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Desarrolladores
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => 'dev'.$i.'@empresa.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'salary' => $faker->randomFloat(2, 2000, 3000),
                'hire_date' => now()->subMonths($i + 3),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
