<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 2,
            'amount'    => 475
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 4,
            'amount'    => 550
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 6,
            'amount'    => 500
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 3,
            'amount'    => 850
        ]);
        
        DB::table('project_members')->insert([
            'project_id'    => 2,
            'user_id'       => 9,
            'amount'    => 600
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 2,
            'user_id'       => 10,
            'amount'    => 730
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 2,
            'user_id'       => 7,
            'amount'    => 650
        ]);

        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 12,
            'amount'    => 440
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 11,
            'amount'    => 580
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 8,
            'amount'    => 830
        ]);
    }
}
