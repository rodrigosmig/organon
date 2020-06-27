<?php

namespace App\Http\Requests;

use App\User;
use App\Project;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /* $project = Project::find($this->project_id);

        if (!$project) {
            return false;
        } */

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
            'description'   => 'required|min:5',
            'deadline'      => 'required|date|after:today',
            'project_id'    => 'required',
            'user_id'       => [
                'nullable',
                Rule::exists(User::class, 'id')->where(function($query) {
                    $query->where('id', $this->user_id);
                })
            ]
        ];
    }
}
