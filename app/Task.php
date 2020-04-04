<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    
    const STATUS = [
        'open'    => "Open", 
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
     * Returns true if the task belongs to the given project id
     *
     * @var int $project_id
     * @return bool
     */
    public function checkByProjectId($project_id)
    {
        if ($this->project->id == $project_id) {
            return true;
        }

        return false;
    }
}
