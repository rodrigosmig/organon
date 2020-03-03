<?php

use App\Project;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'name'      => 'APP Meudinherim',
            'owner_id'  => 1,
        ]);
        Project::create([
            'name'      => 'Gestão de Rotas',
            'owner_id'  => 1,
        ]);
        Project::create([
            'name'      => 'Meudinherim/laravel',
            'owner_id'  => 1,
        ]);
        Project::create([
            'name'      => 'Orty',
            'owner_id'  => 2,
        ]);
    }
}
