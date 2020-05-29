<?php

namespace Tests\Unit;

use App\Task;
use App\User;
use App\Project;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['photo' => 'user.png']);

        Storage::fake('testing');
    }

    /**
     * @test
     */
    public function checkUser()
    {
        $testUser = factory(User::class)->create();

        $this->assertFalse($this->user->checkUser($testUser));
        $this->assertTrue($this->user->checkUser($this->user));
    }

    /**
     * @test
     */
    public function setPhoto()
    {
        $image = UploadedFile::fake()->create('image.jpg')->store('photo', 'testing');
        $this->user->setPhoto($image);
 
        $this->assertEquals($image, $this->user->photo);
        Storage::disk('testing')->assertExists($image);
    }

    /**
     * @test
     */
    public function deletePhoto()
    {
        $file = UploadedFile::fake()->create('image.jpg')->store('photo', 'testing');
        $this->user->setPhoto($file);
        $this->assertEquals($file, $this->user->photo);
        Storage::disk('testing')->assertExists($this->user->photo);

        $this->user->deletePhoto();
 
        $this->assertFalse($this->user->hasPhoto());
        Storage::disk('testing')->assertMissing($this->user->photo);
    }
    
    /**
     * @test
     */
    public function hasPhoto()
    {
        $this->assertFalse($this->user->hasPhoto());

        $image = UploadedFile::fake()->create('image.jpg')->store('photo', 'testing');
        $this->user->setPhoto($image);

        $this->assertTrue($this->user->hasPhoto());

        $this->user->deletePhoto();
        $this->assertFalse($this->user->hasPhoto());
    }

    /**
     * @test
     */
    public function countAllProjects()
    {
        $project1 = factory(Project::class)->create(['owner_id' => $this->user->id]);
        $project2 = factory(Project::class)->create();

        $this->assertEquals(1, $this->user->countAllProjects());

        $project3 = factory(Project::class)->create(['owner_id' => $this->user->id]);

        $this->assertEquals(2, $this->user->countAllProjects());        
    }

    /**
     * @test
     */
    public function countAllTasks()
    {
        $task1 = factory(Task::class)->create(['user_id' => $this->user->id]);
        $task2 = factory(Task::class)->create();

        $this->assertEquals(1, $this->user->countAllTasks());

        $task3 = factory(Task::class)->create(['user_id' => $this->user->id]);

        $this->assertEquals(2, $this->user->countAllTasks());        
    }

    /**
     * @test
     */
    public function countActiveProjects()
    {
        $this->actingAs($this->user);

        $project1 = factory(Project::class)->create(['owner_id' => $this->user->id]);
        $this->assertEquals(1, $this->user->countActiveProjects());

        $project2 = factory(Project::class)->create(['owner_id' => $this->user->id]);
        $this->assertEquals(2, $this->user->countActiveProjects());

        $project3 = factory(Project::class)->create(['owner_id' => $this->user->id]);
        $project4 = factory(Project::class)->create(['owner_id' => $this->user->id]);
        $this->assertEquals(4, $this->user->countActiveProjects());
    }
}
