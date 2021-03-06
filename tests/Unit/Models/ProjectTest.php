<?php

namespace Tests\Unit\Models;

use App\Task;
use App\User;
use App\Client;
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

        $this->project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
            'amount_charged' => 100.00,
            'deadline' => now()->modify('-1 days')->format('Y-m-d'),
            'client_id' => factory(Client::class)
        ]);
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

        $this->project->addMember($user, 100);

        $now = now();

        $taskTime = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+2 hour')->getTimestamp(),
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);

        $this->assertEquals(100, $this->project->getTotalProjectCost());
    }

    /**
     * @test
     */
    public function getTotalCostActiveProjects()
    {
        $this->actingAs($this->user);

        $user = factory(User::class)->create();

        $this->project->addMember($user, 500);

        $task = factory(Task::class)->create([
            'user_id' => $user->id,
            'project_id' => $this->project->id
        ]);        

        $now = now();

        $taskTime = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+2 hour')->getTimestamp(),
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);

        $user2 = factory(User::class)->create();
        $project2 = factory(Project::class)->create(['owner_id' => $this->user]);
        $project2->addMember($user2, 300);

        $task2 = factory(Task::class)->create([
            'user_id' => $user2->id,
            'project_id' => $project2->id
        ]);

        $taskTime2 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+1 hour')->getTimestamp(),
            'user_id' => $user2->id,
            'task_id' => $task2->id,
        ]);

        $this->assertEquals(800.0, Project::getTotalCostActiveProjects());
    }

    /**
     * @test
     */
    public function getTotalValueOfActiveProjects()
    {
        $this->actingAs($this->user);

        $project2 = factory(Project::class)->create([
            'owner_id' => $this->user->id,
            'amount_charged' => 350.00
        ]);

        $project3 = factory(Project::class)->create([
            'owner_id' => $this->user->id,
            'amount_charged' => 630.00
        ]);

        $this->assertEquals(1080, Project::getTotalValueOfActiveProjects());
    }

    /**
     * @test
     */
    public function getDelayedProjects()
    {
        $this->actingAs($this->user);

        $this->assertEquals(1, Project::getDelayedProjects()->count());

        $now = now();

        $project = factory(Project::class)->create([
            'owner_id' => $this->user->id,
            'deadline' => $now->modify('-2 days')
        ]);
        
        $this->assertEquals(2, Project::getDelayedProjects()->count());
    }

    /**
     * @test
     */
    public function getProjectsProgress()
    {
        $task1 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status' => Task::FINISHED
        ]);
        
        $task2 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status' => Task::FINISHED
        ]);

        $task3 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $task4 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $this->assertEquals(50, $this->project->getProjectsProgress());

        $task5 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $this->assertEquals(40, $this->project->getProjectsProgress());
    }

    /**
     * @test
     */
    public function hasTaskInProgress()
    {
        $this->actingAs($this->user);

        $task = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
        ]);

        $this->assertFalse($this->project->hasTaskInProgress());
        
        $task->startTime();
        
        $this->assertTrue($this->project->hasTaskInProgress());
    }

    /**
     * @test
     */
    public function isActive()
    {
        $this->assertTrue($this->project->isActive());

        $this->project->status = Project::FINISHED;

        $this->assertFalse($this->project->isActive());
    }

    /**
     * @test
     */
    public function hasOpenTask()
    {
        $task1 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
        ]);

        $this->assertTrue($this->project->hasOpenTask());
    }
}
