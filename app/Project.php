<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * Fetch projects by given owner id.
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
    public static function getProjectsByUserId($id)
    {
        return Project::where('owner_id', $id)->get();
    }

    public function getOwner()
    {
        return User::find($this->owner_id);
    }
}
