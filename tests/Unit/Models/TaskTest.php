<?php

namespace Tests\Unit\Models;

use App\Task;
use App\User;
use App\Project;
use App\TaskTime;
use Tests\TestCase;

class TaskTest extends TestCase
{
    private $project;
    private $task;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();

        $this->project = factory(Project::class)->create(['owner_id' => $this->user->id]);

        $this->task = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $now = now();

        $taskTime1 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+1 hour')->getTimestamp(),
            'user_id' => $this->user->id,
            'task_id' => $this->task->id,
        ]);

        $taskTime2 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+1 hour')->getTimestamp(),
            'user_id' => $this->user->id,
            'task_id' => $this->task->id,
        ]);
    }

    /**
     * @test
     */
    public function getTotalWorked()
    {
        $user = factory(User::class)->create();

        $now = now();

        $taskTime = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+30 minutes')->getTimestamp(),
            'user_id' => $user->id,
            'task_id' => $this->task->id,
        ]);


        $this->assertEquals(9000, $this->task->getTotalWorked());
    }

    /**
     * @test
     */
    public function getTotalWorkedByUser()
    {
        $this->assertEquals(7200, $this->task->getTotalWorkedByUser($this->user->id));

        $now = now();

        $taskTime = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+30 minutes')->getTimestamp(),
            'user_id' => $this->user->id,
            'task_id' => $this->task->id,
        ]);
        
        $this->assertEquals(9000, $this->task->getTotalWorkedByUser($this->user->id));
    }

    /**
     * @test
     */
    public function checkByProjectId()
    {
        $this->assertTrue($this->task->checkByProjectId($this->project->id));
        
        $task = factory(Task::class)->create();

        $this->assertFalse($task->checkByProjectId($this->project->id));
    }

    /**
     * @test
     */
    public function getUserTasksGroupedByProjects()
    {
        $this->actingAs($this->user);

        $task = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'status' => Task::FINISHED,
            'project_id' => $this->project->id,
        ]);

        $tasks1 = $this->task->getUserTasksGroupedByProjects();

        $this->assertTrue(isset($tasks1[Task::OPEN]));
        $this->assertTrue(isset($tasks1[Task::FINISHED]));

    }

    /**
     * @test
     */
    public function startTime()
    {
        $this->actingAs($this->user);

        $time = $this->task->startTime();
        $this->assertEquals('success', $time['status']);

        $time = $this->task->startTime();
        $this->assertEquals('error', $time['status']);
    }

    /**
     * @test
     */
    public function pauseTime()
    {
        $this->actingAs($this->user);

        $time = $this->task->pauseTime();
        $this->assertEquals('error', $time['status']);

        $time = $this->task->startTime();
        $this->assertEquals('success', $time['status']);

        $time = $this->task->pauseTime();
        $this->assertEquals('success', $time['status']);
    }

    /**
     * @test
     */
    public function resetTime()
    {
        $user = factory(User::class)->create();
        $this->task->user_id = $user->id;
        $this->task->save();

        $now = now();

        $taskTime1 = factory(TaskTime::class)->create([
            'start' => $now->getTimestamp(),
            'end' => $now->modify('+1 hour')->getTimestamp(),
            'user_id' => $user,
            'task_id' => $this->task->id,
        ]);
        
        $this->actingAs($this->user);

        $delete1 = $this->task->resetTime();
        $this->assertEquals('success', $delete1['status']);
        $delete2 = $this->task->resetTime();
        $this->assertEquals('error', $delete2['status']);

        $this->actingAs($user);

        $delete3 = $this->task->resetTime();
        $this->assertEquals('success', $delete3['status']);

        $delete4 = $this->task->resetTime();
        $this->assertEquals('error', $delete4['status']);
    }

    /**
     * @test
     */
    public function updateTime()
    {
        $this->actingAs($this->user);

        $response = $this->task->updateTime(Task::START);
        $this->assertEquals('success', $response['status']);

        $response2 = $this->task->updateTime(Task::START);
        $this->assertEquals('error', $response2['status']);

        $response3 = $this->task->updateTime(Task::PAUSE);
        $this->assertEquals('success', $response3['status']);

        $response4 = $this->task->updateTime(Task::PAUSE);
        $this->assertEquals('error', $response4['status']);

        $response5 = $this->task->updateTime(Task::RESET);
        $this->assertEquals('success', $response5['status']);

        $response6 = $this->task->updateTime(Task::RESET);
        $this->assertEquals('error', $response6['status']);
    }

    /**
     * @test
     */
    public function getTimeStarted()
    {
        $this->actingAs($this->user);

        $this->assertNull($this->task->getTimeStarted());

        $this->task->updateTime(Task::START);

        $this->assertNotNull($this->task->getTimeStarted());
    }

    /**
     * @test
     */
    public function taskInProgress()
    {
        $this->actingAs($this->user);

        $this->assertFalse($this->task->taskInProgress());

        $this->task->updateTime(Task::START);

        $this->assertTrue($this->task->taskInProgress());
    }

    /**
     * @test
     */
    public function finishTask()
    {
        $this->assertFalse($this->task->isFinished());

        $this->assertTrue($this->task->finishTask());

        $this->assertTrue($this->task->isFinished());

        $this->assertFalse($this->task->finishTask());
    }

    /**
     * @test
     */
    public function openTask()
    {
        $this->assertTrue($this->task->finishTask());

        $this->assertTrue($this->task->isFinished());

        $this->assertTrue($this->task->openTask());

        $this->assertFalse($this->task->isFinished());

        $this->assertFalse($this->task->openTask());
    }

    /**
     * @test
     */
    public function getTasksByStatus()
    {
        $this->actingAs($this->user);

        $task1 = factory(Task::class)->create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id
        ]);

        $this->assertEquals(2, Task::getTasksByStatus(Task::OPEN)->count());

        $task1->finishTask();
        $task1->save();

        $this->assertEquals(1, Task::getTasksByStatus(Task::OPEN)->count());
        $this->assertEquals(1, Task::getTasksByStatus(Task::FINISHED)->count());
    }
}
