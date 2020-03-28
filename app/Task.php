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
}
