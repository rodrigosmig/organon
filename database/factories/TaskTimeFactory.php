<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use App\TaskTime;
use Faker\Generator as Faker;

$factory->define(TaskTime::class, function (Faker $faker) {
    return [
        'start' => now()->getTimestamp(),
        'end' => now()->modify('+1 hour')->getTimestamp(),
        'user_id' => factory(User::class),
        'task_id' => factory(Task::class),
    ];
});
