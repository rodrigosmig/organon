<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'name'      => 'Barbara Allen',
            'email'     => 'barbara@gmail.com',
            'owner_id'  => 1,
        ]);
        Client::create([
            'name'      => 'Barbara Allen',
            'email'     => 'barbara@gmail.com',
            'owner_id'  => 1,
        ]);
        Client::create([
            'name'      => 'Larry Meyers',
            'email'     => 'barbara@gmail.com',
            'owner_id'  => 1,
        ]);
        Client::create([
            'name'      => 'Dunder Mifflin',
            'email'     => 'barbara@gmail.com',
            'owner_id'  => 2,
        ]);
    }
}
