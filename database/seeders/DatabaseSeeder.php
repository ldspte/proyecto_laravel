<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ProjectsTableSeeder;
use Database\Seeders\TasksTableSeeder;
use Database\Seeders\TeamsTableSeeder;
use Database\Seeders\RolesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        RolesTableSeeder::class,
        UsersTableSeeder::class,
        TeamsTableSeeder::class,
        ProjectsTableSeeder::class,
        TasksTableSeeder::class,
    ]);
    }
}
