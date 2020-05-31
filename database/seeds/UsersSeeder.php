<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Michael Scott',
            'email'     => 'michael@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/pwFU6I5HxQVeOGem0LEaK3NWY3XoK98dFENYCe6F.jpeg'
        ]);
        User::create([
            'name'      => 'Pam Beesly',
            'email'     => 'pam@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/3SagOjd7UwF2qXdkkWb61R8f7sP4yAEqnTnDgYrs.png'
        ]);
        User::create([
            'name'      => 'Jim Halpert',
            'email'     => 'jim@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/f24iQgDrHX7y1HX9jQZIezTpieG8pS4fMwqNWcOM.jpeg'
        ]);
        User::create([
            'name'      => 'Dwight Schrute',
            'email'     => 'dwight@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/YSOLYC5GRELX4uNhphISUxz97IjhnA7sbbZESzC4.jpeg'
        ]);
        User::create([
            'name'      => 'Ryan Howard',
            'email'     => 'ryan@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/YIpQFSTrkDWPoEoF3fzICszxaAC9xdeyqJsLDCoF.jpeg'
        ]);
        User::create([
            'name'      => 'Angela Martin',
            'email'     => 'angela@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/XgzZoFvVeNOKeCBLHnBJqTCXNKQkBhsdBzzJTNnA.jpeg'
        ]);
        User::create([
            'name'      => 'Kevin Malone',
            'email'     => 'kevin@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/VbHyg9wpehn3U8g8uq7fo1qJwZq0vBi5rC1g6jlh.jpeg'
        ]);
        User::create([
            'name'      => 'Oscar Martinez ',
            'email'     => 'oscar@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/ajju2mqV0mQDE9lEE2yswuyC8W8V2YQNBe5gCrEz.jpeg'
        ]);
        User::create([
            'name'      => 'Stanley Hudson',
            'email'     => 'stanley@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/tPpVoFs9AihUffHuHOd0vXJaqNofaWh2fVeykjyT.jpeg'
        ]);
        User::create([
            'name'      => 'Creed Bratton',
            'email'     => 'creed@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/rhsPs4tjqqLRpFCzzcrMsDFTx6fLbqaqKW5kXdIu.jpeg'
        ]);
        User::create([
            'name'      => 'Phyllis Lapin',
            'email'     => 'phyllis@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/UZ5oxnBp32sLchX8WmkLa9somF5eAwmlQoo8jUbx.jpeg'
        ]);
        User::create([
            'name'      => 'Kelly Kapoor',
            'email'     => 'kelly@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/E0GYqe9z70a4sOJQMmyh5Rk6LJIh1OsX7zkd7nYR.jpeg'
        ]);
    }
}
