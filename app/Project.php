<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

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
     * Fetch project users.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'project_members');
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

    public function getOwner()
    {
        return User::find($this->owner_id);
    }
}
