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
            'name'          => 'Web System for Dunder Mifflin',
            'deadline'      => now()->modify("+5 days")->format('Y-m-d'),
            'amount_charged' => 10000,
            'owner_id'      => 1,
            'client_id'     => 1
        ]);
        Project::create([
            'name'      => 'E-commerce System',
            'deadline'  => now()->modify("+30 days")->format('Y-m-d'),
            'amount_charged' => 8500,
            'owner_id'  => 1,
            'client_id'     => 1
        ]);
        Project::create([
            'name'      => 'Finance System',
            'deadline'  => now()->modify("-30 days")->format('Y-m-d'),
            'status' => Project::FINISHED,
            'amount_charged' => 15000,
            'owner_id'  => 1,
            'client_id'     => 1
        ]);
        Project::create([
            'name'      => 'Dunder Mifflin website design',
            'deadline'  => now()->modify("-30 days")->format('Y-m-d'),
            'status'    => Project::FINISHED,
            'amount_charged' => 15000,
            'owner_id'  => 2,
            'client_id' => 4
        ]);
    }
}
