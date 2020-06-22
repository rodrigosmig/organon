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
            'name'      => 'Jan Levinson',
            'email'     => 'jan@gmail.com',
            'owner_id'  => 1,
        ]);
    }
}
