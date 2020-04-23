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
            'photo'     => 'photo/K23H3MzEeSpGqYTQnepal9PdxlPMixCKHF1mCmWN.png'
        ]);
        User::create([
            'name'      => 'Isabela Prado',
            'email'     => 'isabela@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/uogW6LB8Db1cp5e25d74mkM4ESnu7hlruZwdi7rg.jpeg'
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
            'photo'     => 'photo/lgI9zA7DeLv6Q4ooH6yexWqfvCUneC2P0C99FyI2.jpeg'
        ]);
        User::create([
            'name'      => 'Roberto Silva',
            'email'     => 'roberto@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/If6PBBV4fQ2QnnzU1XT0zDnde2y9KdWJcvrtcc19.jpeg'
        ]);
        User::create([
            'name'      => 'Marcela Rafael',
            'email'     => 'marcela@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'photo/QWQtmfWfowqdwQ04MwzwtV4IZKPDNIUaZJDWy1Bx.png'
        ]);
        User::create([
            'name'      => 'Vanessa Guimarães',
            'email'     => 'vanessa@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Rogério Martins',
            'email'     => 'rogerio@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Thiago Santos',
            'email'     => 'thiago@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Felipe Figueireiro',
            'email'     => 'felipe@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Raíssa Fernandes',
            'email'     => 'raissa@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
        User::create([
            'name'      => 'Letícia Rocha',
            'email'     => 'leticia@gmail.com',
            'password'  => Hash::make('12345678'),
            'photo'     => 'user.png'
        ]);
    }
}
