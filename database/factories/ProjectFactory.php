<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'deadline' => now(),
        'status' => Project::ACTIVE,
        'owner_id' => factory(User::class)
    ];
});
