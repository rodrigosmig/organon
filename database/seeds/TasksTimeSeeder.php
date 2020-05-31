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
            'start'     => now()->modify("-30 days")->getTimestamp(),
            'end'       => now()->modify("-30 days")->modify("+223 minutes")->getTimestamp(),
            'user_id'   => 2
        ]);
        TaskTime::create([
            'task_id'   => 1,
            'start'     => now()->modify("-28 days")->getTimestamp(),
            'end'       => now()->modify("-28 days")->modify("+91 minutes")->getTimestamp(),
            'user_id'   => 2
        ]);
        TaskTime::create([
            'task_id'   => 1,
            'start'     => now()->modify("-27 days")->getTimestamp(),
            'end'       => now()->modify("-27 days")->modify("+87 minutes")->getTimestamp(),
            'user_id'   => 2
        ]);
        TaskTime::create([
            'task_id'   => 2,
            'start'     => now()->modify("-25 days")->getTimestamp(),
            'end'       => now()->modify("-25 days")->modify("+199 minutes")->getTimestamp(),
            'user_id'   => 4
        ]);
        TaskTime::create([
            'task_id'   => 2,
            'start'     => now()->modify("-24 days")->getTimestamp(),
            'end'       => now()->modify("-24 days")->modify("+81 minutes")->getTimestamp(),
            'user_id'   => 4
        ]);
        TaskTime::create([
            'task_id'   => 3,
            'start'     => now()->modify("-18 days")->getTimestamp(),
            'end'       => now()->modify("-18 days")->modify("+125 minutes")->getTimestamp(),
            'user_id'   => 2
        ]);
        TaskTime::create([
            'task_id'   => 4,
            'start'     => now()->modify("-15 days")->getTimestamp(),
            'end'       => now()->modify("-15 days")->modify("+221 minutes")->getTimestamp(),
            'user_id'   => 6
        ]);
        TaskTime::create([
            'task_id'   => 4,
            'start'     => now()->modify("-14 days")->getTimestamp(),
            'end'       => now()->modify("-14 days")->modify("+178 minutes")->getTimestamp(),
            'user_id'   => 6
        ]);

        TaskTime::create([
            'task_id'   => 5,
            'start'     => now()->modify("-10 days")->getTimestamp(),
            'end'       => now()->modify("-10 days")->modify("+67 minutes")->getTimestamp(),
            'user_id'   => 9
        ]);
        TaskTime::create([
            'task_id'   => 5,
            'start'     => now()->modify("-09 days")->getTimestamp(),
            'end'       => now()->modify("-09 days")->modify("+57 minutes")->getTimestamp(),
            'user_id'   => 10
        ]);
        TaskTime::create([
            'task_id'   => 6,
            'start'     => now()->modify("-07 days")->getTimestamp(),
            'end'       => now()->modify("-07 days")->modify("+73 minutes")->getTimestamp(),
            'user_id'   => 10
        ]);
        TaskTime::create([
            'task_id'   => 6,
            'start'     => now()->modify("-06 days")->getTimestamp(),
            'end'       => now()->modify("-06 days")->modify("+114 minutes")->getTimestamp(),
            'user_id'   => 10
        ]);
        TaskTime::create([
            'task_id'   => 7,
            'start'     => now()->modify("-09 days")->getTimestamp(),
            'end'       => now()->modify("-09 days")->modify("+95 minutes")->getTimestamp(),
            'user_id'   => 9
        ]);
        TaskTime::create([
            'task_id'   => 7,
            'start'     => now()->modify("-07 days")->getTimestamp(),
            'end'       => now()->modify("-07 days")->modify("+114 minutes")->getTimestamp(),
            'user_id'   => 9
        ]);
        TaskTime::create([
            'task_id'   => 8,
            'start'     => now()->modify("+05 days")->getTimestamp(),
            'end'       => now()->modify("+05 days")->modify("+74 minutes")->getTimestamp(),
            'user_id'   => 7
        ]);
        TaskTime::create([
            'task_id'   => 8,
            'start'     => now()->modify("+10 days")->getTimestamp(),
            'end'       => now()->modify("+10 days")->modify("+82 minutes")->getTimestamp(),
            'user_id'   => 7
        ]);
        TaskTime::create([
            'task_id'   => 8,
            'start'     => now()->modify("+11 days")->getTimestamp(),
            'end'       => now()->modify("+11 days")->modify("+149 minutes")->getTimestamp(),
            'user_id'   => 7
        ]);
        TaskTime::create([
            'task_id'   => 9,
            'start'     => now()->modify("+10 days")->getTimestamp(),
            'end'       => now()->modify("+10 days")->modify("+154 minutes")->getTimestamp(),
            'user_id'   => 9
        ]);
        TaskTime::create([
            'task_id'   => 9,
            'start'     => now()->modify("+11 days")->getTimestamp(),
            'end'       => now()->modify("+11 days")->modify("+193 minutes")->getTimestamp(),
            'user_id'   => 9
        ]);
        TaskTime::create([
            'task_id'   => 9,
            'start'     => now()->modify("+12 days")->getTimestamp(),
            'end'       => now()->modify("+12 days")->modify("+171 minutes")->getTimestamp(),
            'user_id'   => 9
        ]);

        TaskTime::create([
            'task_id'   => 10,
            'start'     => now()->modify("-48 days")->getTimestamp(),
            'end'       => now()->modify("-48 days")->modify("+132 minutes")->getTimestamp(),
            'user_id'   => 12
        ]);
        TaskTime::create([
            'task_id'   => 10,
            'start'     => now()->modify("-47 days")->getTimestamp(),
            'end'       => now()->modify("-47 days")->modify("+81 minutes")->getTimestamp(),
            'user_id'   => 12
        ]);
        TaskTime::create([
            'task_id'   => 10,
            'start'     => now()->modify("-46 days")->getTimestamp(),
            'end'       => now()->modify("-46 days")->modify("+77 minutes")->getTimestamp(),
            'user_id'   => 12
        ]);
        TaskTime::create([
            'task_id'   => 11,
            'start'     => now()->modify("-45 days")->getTimestamp(),
            'end'       => now()->modify("-45 days")->modify("+77 minutes")->getTimestamp(),
            'user_id'   => 11
        ]);
        TaskTime::create([
            'task_id'   => 11,
            'start'     => now()->modify("-43 days")->getTimestamp(),
            'end'       => now()->modify("-43 days")->modify("+77 minutes")->getTimestamp(),
            'user_id'   => 11
        ]);
        TaskTime::create([
            'task_id'   => 11,
            'start'     => now()->modify("-41 days")->getTimestamp(),
            'end'       => now()->modify("-41 days")->modify("+117 minutes")->getTimestamp(),
            'user_id'   => 11
        ]);
        TaskTime::create([
            'task_id'   => 12,
            'start'     => now()->modify("-37 days")->getTimestamp(),
            'end'       => now()->modify("-37 days")->modify("+117 minutes")->getTimestamp(),
            'user_id'   => 8
        ]);
        TaskTime::create([
            'task_id'   => 12,
            'start'     => now()->modify("-35 days")->getTimestamp(),
            'end'       => now()->modify("-35 days")->modify("+135 minutes")->getTimestamp(),
            'user_id'   => 8
        ]);
        TaskTime::create([
            'task_id'   => 12,
            'start'     => now()->modify("-34 days")->getTimestamp(),
            'end'       => now()->modify("-34 days")->modify("+96 minutes")->getTimestamp(),
            'user_id'   => 8
        ]);
        TaskTime::create([
            'task_id'   => 12,
            'start'     => now()->modify("-30 days")->getTimestamp(),
            'end'       => now()->modify("-30 days")->modify("+155 minutes")->getTimestamp(),
            'user_id'   => 8
        ]);
        TaskTime::create([
            'task_id'   => 12,
            'start'     => now()->modify("-29 days")->getTimestamp(),
            'end'       => now()->modify("-29 days")->modify("+198 minutes")->getTimestamp(),
            'user_id'   => 8
        ]);
        TaskTime::create([
            'task_id'   => 13,
            'start'     => now()->modify("-35 days")->getTimestamp(),
            'end'       => now()->modify("-35 days")->modify("+114 minutes")->getTimestamp(),
            'user_id'   => 1
        ]);
        TaskTime::create([
            'task_id'   => 13,
            'start'     => now()->modify("-34 days")->getTimestamp(),
            'end'       => now()->modify("-34 days")->modify("+126 minutes")->getTimestamp(),
            'user_id'   => 1
        ]);
        TaskTime::create([
            'task_id'   => 13,
            'start'     => now()->modify("-33 days")->getTimestamp(),
            'end'       => now()->modify("-33 days")->modify("+219 minutes")->getTimestamp(),
            'user_id'   => 1
        ]);
        TaskTime::create([
            'task_id'   => 13,
            'start'     => now()->modify("-32 days")->getTimestamp(),
            'end'       => now()->modify("-32 days")->modify("+278 minutes")->getTimestamp(),
            'user_id'   => 1
        ]);
    }
}
