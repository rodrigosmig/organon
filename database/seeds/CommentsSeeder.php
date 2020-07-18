<?php

use App\Comment;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create([
            'comment'       => 'I need a prototype as soon as possible',
            'user_id'       => 1,
            'task_id'       => 3,
        ]);

        Comment::create([
            'comment'       => 'Ok.',
            'user_id'       => 3,
            'task_id'       => 3,
        ]);
    }
}
