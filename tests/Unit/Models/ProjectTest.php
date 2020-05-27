<?php

namespace Tests\Unit\Models;

use App\Task;
use App\User;
use App\Project;
use App\TaskTime;
use PDOException;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    private $user;
    private $project;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();

        $this->project = factory(Project::class)->create(['owner_id' => $this->user->id]);
    }

    /**
     * @test
     */
    public function getProjectsByOwnerId()
    {
        $this->assertEquals(1, $this->project->getProjectsByOwnerId($this->user->id)->count());
        
        $new_project = factory(Project::class)->create(['owner_id' => $this->user->id]);
              
        $this->assertEquals(2, $this->project->getProjectsByOwnerId($this->user->id)->count());
        
        $this->assertEquals(0, $this->project->getProjectsByOwnerId(654564)->count());
    }

    /**
     * @test
     */
    public function getProjectsByStatus()
    {
        $active_projects    = factory(Project::class, 2)->create(['owner_id' => $this->user->id]);
        $finished_projects  = factory(Project::class, 5)->create([
            'owner_id' => $this->user->id,
            'status' => Project::FINISHED
        ]);            
        $other_project = factory(Project::class, 2)->create();
        
        $this->actingAs($this->user);

        $number_of_active_projects = Project::getProjectsByStatus(Project::ACTIVE)->count();
        $this->assertEquals(3, $number_of_active_projects);
        
        $number_of_finished_projects = Project::getProjectsByStatus(Project::FINISHED)->count();
        $this->assertEquals(5, $number_of_finished_projects);
    }

    /**
     * @test
     */
    public function addMember()
    {
        $this->expectException(PDOException::class);

        $project = factory(Project::class)->create(['owner_id' => $this->user->id]);
        $user1 = factory(User::class)->create();
      
        $project->addMember($user1, 0);
        
        $this->assertTrue($project->isMember($user1));
        $this->assertEquals(2, $project->getAllProjectMembers()->count());
        
        $project->addMember($user1, 0);
    }

    /**
     * @test
     */
    public function getAllProjectMembers()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->project->addMember($user1, 0);
        $this->project->addMember($user2, 0);
      
        $this->assertEquals(3, $this->project->getAllProjectMembers()->count());        
    }

    /**
     * @test
     */
    public function isMember()
    {
        $user1 = factory(User::class)->create();

        $this->project->addMember($user1, 0);
      
        $this->assertTrue($this->project->isMember($user1));
    }

    /**
     * @test
     */
    public function getTasksByUserId()
    {
        $tasks = factory(Task::class, 4)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $this->assertEquals(4, $this->project->getTasksByUserId($this->user->id)->count());

        $tasks2 = factory(Task::class, 2)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $Other_task = factory(Task::class)->create();

        $this->assertEquals(6, $this->project->getTasksByUserId($this->user->id)->count());
    }

    /**
     * @test
     */
    public function getTotalWorkedOnProjectByUserId()
    {
        $task1 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $task2 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);
        
        $now = now();

        $taskTime1 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+1 hour')->getTimestamp(),
            'user_id' => $this->user->id,
            'task_id' => $task1->id,
        ]);

        $this->assertEquals(3600, $this->project->getTotalWorkedOnProjectByUserId($this->user->id));

        $taskTime2 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+30 minutes')->getTimestamp(),
            'user_id' => $this->user->id,
            'task_id' => $task2->id,
        ]);
        
        $this->assertEquals(5400, $this->project->getTotalWorkedOnProjectByUserId($this->user->id));
    }

    /**
     * @test
     */
    public function getTotalWorkedOnProject()
    {
        $user = factory(User::class)->create();
        $this->project->addMember($user, 0);

        $task1 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $task2 = factory(Task::class)->create([
            'user_id' => $user->id,
            'project_id' => $this->project->id
        ]);
        
        $now = now();

        $taskTime1 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+1 hour')->getTimestamp(),
            'user_id' => $this->user->id,
            'task_id' => $task1->id,
        ]);

        $taskTime2 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+1 hour')->getTimestamp(),
            'user_id' => $user->id,
            'task_id' => $task2->id,
        ]);

        $this->assertEquals(7200, $this->project->getTotalWorkedOnProject());
        
        $taskTime3 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+30 minutes')->getTimestamp(),
            'user_id' => $user->id,
            'task_id' => $task2->id,
        ]);

        $this->assertEquals(9000, $this->project->getTotalWorkedOnProject());
    }

    /**
     * @test
     */
    public function isOwner()
    {
        $user = factory(User::class)->create();
        $this->assertFalse($this->project->isOwner($user));
        $this->assertTrue($this->project->isOwner($this->user));
    }

    /**
     * @test
     */
    public function getTotalProjectCost()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create([
            'user_id' => $user->id,
            'project_id' => $this->project->id
        ]);

        $this->project->addMember($user, 10);

        $now = now();

        $taskTime = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+2 hour')->getTimestamp(),
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);

        $this->assertEquals(20, $this->project->getTotalProjectCost());
    }
}
