<?php

namespace App\Http\Requests;

use App\Task;
use App\User;
use App\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TaskValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $task       = Task::find($this->task_id);
        $project    = Project::find($this->project_id);
        //dd($this->project_id, $this->task_id);
        if($task && $project) {
            if(!$project->isMember(Auth::user())) {dd(1);
                return false;
            }
    
            if (!$task->checkByProjectId($project->id)) {dd(2);
                return false;
            }
    
            if (!Auth::user()->checkUser($task->user)) {dd(3);
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_id' => [
                'required',
                Rule::exists(Task::class, 'id')->where(function($query) {
                    $query->where('id', $this->task_id);
                })
            ],
            'project_id' => [
                'required',
                Rule::exists(Project::class, 'id')->where(function($query) {
                    $query->where('id', $this->project_id);
                })
            ]
        ];

    }
}
