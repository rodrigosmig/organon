<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'owner_id' => factory(User::class),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'status' => 'active'
    ];
});
