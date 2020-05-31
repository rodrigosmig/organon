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
            'hour_value'    => 95
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 4,
            'hour_value'    => 90
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 6,
            'hour_value'    => 110
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 3,
            'hour_value'    => 100
        ]);
        
        DB::table('project_members')->insert([
            'project_id'    => 2,
            'user_id'       => 9,
            'hour_value'    => 95
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 2,
            'user_id'       => 10,
            'hour_value'    => 115
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 2,
            'user_id'       => 7,
            'hour_value'    => 135
        ]);

        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 12,
            'hour_value'    => 110
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 11,
            'hour_value'    => 125
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 8,
            'hour_value'    => 100
        ]);
    }
}
