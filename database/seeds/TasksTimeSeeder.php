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
            'start'     => Carbon::createFromFormat('d/m/Y H:i:s', '15/03/2020 08:30:15')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y H:i:s', '15/03/2020 09:58:00')->timestamp,
            'user_id'   => 1
        ]);

        TaskTime::create([
            'task_id'   => 1,
            'start'     => Carbon::createFromFormat('d/m/Y H:i:s', '15/03/2020 11:30:33')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y H:i:s', '15/03/2020 14:41:09')->timestamp,
            'user_id'   => 1
        ]);

        TaskTime::create([
            'task_id'   => 1,
            'start'     => Carbon::createFromFormat('d/m/Y H:i:s', '16/03/2020 09:15:33')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y H:i:s', '16/03/2020 12:44:59')->timestamp,
            'user_id'   => 1
        ]);

        TaskTime::create([
            'task_id'   => 1,
            'start'     => Carbon::createFromFormat('d/m/Y H:i:s', '17/03/2020 10:23:33')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y H:i:s', '17/03/2020 12:11:22')->timestamp,
            'user_id'   => 2
        ]);

        TaskTime::create([
            'task_id'   => 1,
            'start'     => Carbon::createFromFormat('d/m/Y H:i:s', '18/03/2020 13:30:41')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y H:i:s', '18/03/2020 16:46:17')->timestamp,
            'user_id'   => 2
        ]);

        TaskTime::create([
            'task_id'   => 2,
            'start'     => Carbon::createFromFormat('d/m/Y H:i:s', '13/04/2020 08:25:13')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y H:i:s', '13/04/2020 09:30:06')->timestamp,
            'user_id'   => 4
        ]);

        TaskTime::create([
            'task_id'   => 2,
            'start'     => Carbon::createFromFormat('d/m/Y H:i:s', '14/04/2020 14:17:51')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y H:i:s', '14/04/2020 17:47:28')->timestamp,
            'user_id'   => 4
        ]);

        TaskTime::create([
            'task_id'   => 3,
            'start'     => Carbon::createFromFormat('d/m/Y H:i:s', '20/05/2020 10:17:17')->timestamp,
            'end'       => Carbon::createFromFormat('d/m/Y H:i:s', '20/05/2020 12:39:36')->timestamp,
            'user_id'   => 2
        ]);
    }
}
