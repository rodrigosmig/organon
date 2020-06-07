<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(ProjectMembersSeeder::class);
        $this->call(TasksSeeder::class);
        $this->call(TasksTimeSeeder::class);

    }
}
