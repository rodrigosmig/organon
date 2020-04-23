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
            'deadline'  => Carbon\Carbon::createFromFormat('d/m/Y', '01/05/2020'),
            'owner_id'  => 1,
        ]);
        Project::create([
            'name'      => 'Gestão de Rotas',
            'deadline'  => Carbon\Carbon::createFromFormat('d/m/Y', '26/06/2020'),
            'owner_id'  => 1,
        ]);
        Project::create([
            'name'      => 'Meudinherim/laravel',
            'deadline'  => Carbon\Carbon::createFromFormat('d/m/Y', '17/05/2020'),
            'owner_id'  => 1,
        ]);
        Project::create([
            'name'      => 'Orty',
            'deadline'  => Carbon\Carbon::createFromFormat('d/m/Y', '30/04/2020'),
            'owner_id'  => 2,
        ]);
    }
}
