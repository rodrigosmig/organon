<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
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
}
