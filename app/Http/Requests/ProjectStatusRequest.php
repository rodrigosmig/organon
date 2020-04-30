<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProjectStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project    = Project::find($this->id);
        
        if($project) {
            if(!$project->owner->checkUser(Auth::user())) {
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
            'id' => [
                'required',
                Rule::exists(Project::class, 'id')->where(function($query) {
                    $query->where('id', $this->id);
                })
            ]
        ];
    }
}
