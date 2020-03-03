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
            'name'      => 'Rodrigo Miguel',
            'email'     => 'rodrigosmig@outlook.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Isabela Prado',
            'email'     => 'isabela@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Rafaela Medeiros',
            'email'     => 'rafaela@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Lucas Alves',
            'email'     => 'lucas@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Roberto Silva',
            'email'     => 'roberto@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Marcela Rafael',
            'email'     => 'marcela@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Vanessa Guimarães',
            'email'     => 'vanessa@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
    }
}
