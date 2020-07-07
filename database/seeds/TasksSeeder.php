<?php

use App\Project;
use App\Task;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Project1
        Task::create([
            'name'          => 'Layout',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-15 days")->format('Y-m-d'),
            'user_id'       => 2,
            'project_id'    => 1,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Illustration',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-13 days")->format('Y-m-d'),
            'user_id'       => 4,
            'project_id'    => 1,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Frontend',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-10 days")->format('Y-m-d'),
            'user_id'       => 3,
            'project_id'    => 1
        ]);
        Task::create([
            'name'          => 'Backend',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-1 days")->format('Y-m-d'),
            'user_id'       => 6,
            'project_id'    => 1
        ]);

        //Preoject2
        Task::create([
            'name'          => 'Layout',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-5 days")->format('Y-m-d'),
            'user_id'       => 10,
            'project_id'    => 2,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Illustration',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-1 days")->format('Y-m-d'),
            'user_id'       => 10,
            'project_id'    => 2,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Systems Requirement Analysis',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-10 days")->format('Y-m-d'),
            'user_id'       => 9,
            'project_id'    => 2,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Frontend',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("+15 days")->format('Y-m-d'),
            'user_id'       => 7,
            'project_id'    => 2,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Backend',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("+25 days")->format('Y-m-d'),
            'user_id'       => 9,
            'project_id'    => 2
        ]);

         //Preoject3
         Task::create([
            'name'          => 'Layout',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-45 days")->format('Y-m-d'),
            'user_id'       => 12,
            'project_id'    => 3,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Illustration',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-40 days")->format('Y-m-d'),
            'user_id'       => 11,
            'project_id'    => 3,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Frontend',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-25 days")->format('Y-m-d'),
            'user_id'       => 8,
            'project_id'    => 3,
            'status'        => Task::FINISHED
        ]);
        Task::create([
            'name'          => 'Backend',
            'description'   => 'Lorem ipsum phasellus dictumst praesent placerat ad aliquam tortor, luctus sem metus sollicitudin venenatis viverra luctus faucibus etiam, aliquet torquent gravida dictumst iaculis cras aptent. urna auctor posuere enim tristique tellus aliquet ultricies proin, habitant vestibulum eu accumsan mi tellus sollicitudin primis odio, sollicitudin curabitur cursus amet orci inceptos mollis.',
            'deadline'      => now()->modify("-25 days")->format('Y-m-d'),
            'user_id'       => 1,
            'project_id'    => 3,
            'status'        => Task::FINISHED
        ]);
    }
}
