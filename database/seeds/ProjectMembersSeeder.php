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
            'user_id'       => 2
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 4
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 1,
            'user_id'       => 6
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 2,
            'user_id'       => 6
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 2,
            'user_id'       => 7
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 7
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 4
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 6
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 3,
            'user_id'       => 2
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 4,
            'user_id'       => 4
        ]);
        DB::table('project_members')->insert([
            'project_id'    => 4,
            'user_id'       => 7
        ]);
    }
}
