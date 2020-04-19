<?php

namespace App\Http\Requests;

use App\Task;
use App\User;
use App\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AssignTaskMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user       = User::find($this->user_id);
        $task       = Task::find($this->task_id);
        $project    = Project::find($this->project_id);

        if($user && $task && $project) {
            if(!$project->isMember($user)) {
                return false;
            }
    
            if (!$task->checkByProjectId($project->id)) {
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
            'user_id' => [
                'required',
                Rule::exists(User::class, 'id')->where(function($query) {
                    $query->where('id', $this->user_id);
                })
            ],
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
