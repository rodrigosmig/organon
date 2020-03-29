<?php

use App\Project;
use App\Task;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create([
            'description'   => 'Design',
            'deadline'      => Carbon\Carbon::createFromFormat('d/m/Y', '25/03/2020'),
            'user_id'       => 5,
            'project_id'    => 1,
            'status'        => 'finished'
        ]);

        Task::create([
            'description'   => 'Frontend',
            'deadline'      => Carbon\Carbon::createFromFormat('d/m/Y', '29/04/2020'),
            'user_id'       => 2,
            'project_id'    => 1
        ]);

        Task::create([
            'description'   => 'Backend',
            'deadline'      => Carbon\Carbon::createFromFormat('d/m/Y', '25/05/2020'),
            'user_id'       => 4,
            'project_id'    => 1
        ]);
    }
}
