<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    const ACTIVE    = 'active';
    const FINISHED  = 'finished';

    const STATUS = [
        'active'    => "Active", 
        'finished'  => "Finished"
    ];

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'deadline', 'owner_id'];

    /**
     * Fetch project tasks.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * Fetch project members.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function members()
    {
        return $this->belongsToMany('App\User', 'project_members');
    }

    /**
     * Fetch the project owner.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Fetch projects by given owner id.
     *
     * @param  int  $id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getProjectsByOwnerId($id)
    {
        return Project::where('owner_id', $id)->get();
    }

    /**
     * Fetch projects by status.
     *
     * @param  string  $status
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getProjectsByStatus($status)
    {
        return Project::where([
            'owner_id'  => Auth()->user()->id,
            'status'    => $status
        ])->get();
    }
    
    /**
     * Returns all project members
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllProjectMembers()
    {
        $all_members = collect([$this->owner]);

        foreach ($this->members as $member) {
            $all_members->push($member);
        }

        return $all_members;
    }

    /**
     * Checks if the user is a member of the project
     *
     * @param User  $user
     * @return bool
     */
    public function isMember($user)
    {
        return $this->getAllProjectMembers()->contains(function($member) use ($user) {
            return $member->id === $user->id;
        });
    }

    /**
     * Returns the total worked on the project
     *
     * @return int
     */
    public function getTotalWorkedOnProject()
    {
        $members        = $this->getAllProjectMembers();
        $total_worked   = 0;

        foreach ($members as $member) {
            $total_worked += $this->getTotalWorkedOnProjectByUserId($member->id);
        }

        return $total_worked;
    }
    
    /**
     * Returns the total worked on the project for a given user
     *
     * @param int  $user_id
     * @return int
     */
    public function getTotalWorkedOnProjectByUserId($user_id)
    {
        $tasks          = $this->getTasksByUserId($user_id);
        $total_worked   = 0;

        foreach ($tasks as $task) {
            $total_worked += $task->getTotalWorked();
        }

        return $total_worked;
    }

    /**
     * Fetch project tasks by given user id.
     *
     * @param  int  $user_id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getTasksByUserId($user_id)
    {
        return Task::where([
            'project_id'    => $this->id,
            'user_id'       => $user_id
        ])->get();
    }
}
