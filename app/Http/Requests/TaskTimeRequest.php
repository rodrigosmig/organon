<?php

namespace App\Http\Requests;

use App\Task;
use App\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TaskTimeRequest extends FormRequest
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

        if($task && $project) {
            if(!$project->isMember(Auth::user())) {
                return false;
            }
    
            if (!$task->checkByProjectId($project->id)) {
                return false;
            }
    
            if (!Auth::user()->checkUser($task->user)) {
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
                'nullable',
                Rule::exists(Project::class, 'id')->where(function($query) {
                    $query->where('id', $this->project_id);
                })
            ]
        ];
    }
}
