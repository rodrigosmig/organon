<?php

use App\TaskTime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TasksTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskTime::create([
            'task_id'   => 1,
            'start'     => Carbon::createFromFormat('d/m/Y', '15/03/2020')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y', '15/03/2020')->addDay()->timestamp,
        ]);

        TaskTime::create([
            'task_id'   => 1,
            'start'     => Carbon::createFromFormat('d/m/Y', '17/03/2020')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y', '17/03/2020')->addDay()->timestamp,
        ]);

        TaskTime::create([
            'task_id'   => 1,
            'start'     => Carbon::createFromFormat('d/m/Y', '18/03/2020')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y', '18/03/2020')->addDay()->timestamp,
        ]);

        TaskTime::create([
            'task_id'   => 2,
            'start'     => Carbon::create('now')->subDays(3)->timestamp,
            'end'       => Carbon::create('now')->subDays(2)->timestamp
        ]);

        TaskTime::create([
            'task_id'   => 2,
            'start'     => Carbon::create('now')->subDays(2)->timestamp,
            'end'       => Carbon::create('now')->subDays(1)->timestamp
        ]);
    }
}
