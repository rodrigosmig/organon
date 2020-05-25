<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    
    const OPEN      = 'open';
    const FINISHED  = 'finished';
    const START     = 'start';
    const PAUSE     = 'pause';
    const RESET     = 'reset';

    const STATUS = [
        'open'      => "Open", 
        'finished'  => "Finished"
    ];

    protected $fillable = ['description', 'deadline', 'project_id'];

    /**
     * Fetch the task project.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Fetch task times.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function times() {
        return $this->hasMany("App\TaskTime");
    }

    /**
     * Get the task user.
     * 
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns the total worked on the task in seconds
     * 
     * @return App\User
     */
    public function getTotalWorked() :int
    {
        $seconds = 0;
        foreach ($this->times as $time) {
            
            if ($time->start && $time->end) {
                $seconds += ($time->end - $time->start);
            }
        }

        return $seconds;
    }

    /**
     * Returns the total worked on the task in seconds for the given user
     * 
     * @return int
     */
    public function getTotalWorkedByUser() :int
    {
        $seconds = 0;
        
        $task_times = $this->times()
                            ->where(['user_id' => Auth::user()->id])
                            ->get();

        foreach ($task_times as $time) {
            
            if ($time->start && $time->end) {
                $seconds += ($time->end - $time->start);
            }
        }

        return $seconds;
    }

    /**
     * Returns true if the task belongs to the given project id
     *
     * @param  int  $project_id
     * @return bool
     */
    public function checkByProjectId($project_id)
    {
        if ($this->project->id == $project_id) {
            return true;
        }

        return false;
    }

    /**
     * Fetch tasks grouped by projects.
     *
     * @return array
     */
    public static function getUserTasksGroupedByProjects()
    {
        $tasks      = Auth::user()->tasks;
        $projects   = [];
        foreach ($tasks as $task) {
            if ($task->status === static::OPEN) {
                $projects[static::OPEN][$task->project->id][] = $task;
                if (!isset($projects[static::OPEN][$task->project->id]['project_name'])) {
                    $projects[static::OPEN][$task->project->id]['project_name'] = $task->project->name;
                }
            }
            if ($task->status === static::FINISHED) {
                $projects[static::FINISHED][$task->project->id][] = $task;
                if (!isset($projects[static::FINISHED][$task->project->id]['project_name'])) {
                    $projects[static::FINISHED][$task->project->id]['project_name'] = $task->project->name;
                }
            }
        }

        return $projects;
    }

    /**
     * Starts task time.
     *
     * @return array
     */
    public function startTime()
    {
        $task_time = $this->getTimeStarted();

        if(! $task_time) {
            $task = TaskTime::create([
                'start'     => Carbon::create('now')->timestamp,
                'user_id'   => $this->user->id,
                'task_id'   => $this->id
            ]);
    
            return [
                'status' => 'success',
                'msg'    => 'Time started'
            ];
        }

        return [
            'status' => 'error',
            'msg'    => 'Invalid request'
        ];
        
    }

    /**
     * Stops task time.
     *
     * @return array
     */
    public function pauseTime()
    {   
        $task_time = $this->getTimeStarted();
        
        if (!$task_time) {
            return [
                'status' => 'error',
                'msg'    => 'Invalid request'
            ];
        }
        
        $task_time->end = Carbon::create('now')->timestamp;
        $task_time->save();

        return [
            'status' => 'success',
            'msg'    => 'Time paused'
        ]; 
    }

    /**
     * Reset task time.
     *
     * @param User $user
     * @return array
     */
    public function resetTime()
    {
        $delete = $this->times()
                        ->where('user_id', Auth::user()->id)
                        ->delete();

        if ($delete > 0) {
            return [
                'status' => 'success',
                'msg'    => 'Task time has been restarted'
            ];
        }

        return [
            'status' => 'error',
            'msg'    => 'There is no time for this task'
        ];
    }

    /**
     * Update task time.
     *
     * @param string $type
     * @return bool
     */
    public function updateTime($type)
    {
        $response = [
            'status' => 'error',
            'msg'    => 'Unable to update time.'
        ];

        if ($type === static::START) {
            $response = $this->startTime();
        }

        if ($type === static::PAUSE) {
            $response = $this->pauseTime();
        }

        if ($type === static::RESET) {
            $response = $this->resetTime();
        }

        return $response;
    }

    /**
     * Get the last started time
     *
     * @param int $user_id
     * @return App\TaskTime
     */
    public function getTimeStarted()
    {
        return $this->times()
                    ->where('user_id', Auth::user()->id)
                    ->whereNull('end')
                    ->get()
                    ->last();
    }

    /**
     * Checks if the task is in progress.
     *
     * @return bool
     */
    public function taskInProgress()
    {
        return !empty($this->getTimeStarted());
    }

    /**
     * Checks if the task is finished.
     *
     * @return bool
     */
    public function isFinished()
    {
        return $this->status === $this::FINISHED;
    }

    /**
     * Finish task.
     *
     * @return bool
     */
    public function finishTask(): bool
    {
        if ($this->isFinished()) {
            return false;
        }

        $this->status = $this::FINISHED;

        return true;
    }

    /**
     * Open task.
     *
     * @return bool
     */
    public function openTask(): bool
    {
        if (! $this->isFinished()) {
            return false;
        }

        $this->status = $this::OPEN;

        return true;
    }
}
