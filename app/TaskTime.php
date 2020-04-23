<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTime extends Model
{
    protected $fillable = ['start', 'user_id', 'task_id'];
}
