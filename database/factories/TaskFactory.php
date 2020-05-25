<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use App\Project;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'description' => $faker->name,
        'deadline' => now(),
        'status' => Task::OPEN,
        'user_id' => factory(User::class),
        'project_id' => factory(Project::class)
    ];
});
