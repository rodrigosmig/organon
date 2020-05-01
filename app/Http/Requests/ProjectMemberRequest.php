<?php

namespace App\Http\Requests;

use App\User;
use App\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProjectMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'project_id' => [
                'required',
                Rule::exists(Project::class, 'id')->where(function($query) {
                    $query->where('id', $this->project_id);
                })
            ],
            'user_id' => [
                'required',
                Rule::exists(User::class, 'id')->where(function($query) {
                    $query->where('id', $this->user_id);
                })
            ]
        ];
    }
}
