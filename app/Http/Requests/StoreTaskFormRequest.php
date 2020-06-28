<?php

namespace App\Http\Requests;

use App\Client;
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
            'name'          => 'required|min:3',
            'description'   => 'required|min:5',
            'deadline'      => 'required|date|after_or_equal:today',
            'project_id'    => [
                'nullable',
                Rule::exists(Project::class, 'id')->where(function($query) {
                    $query->where('id', $this->project_id);
                })
            ],
            'client_id'       => [
                'nullable',
                Rule::exists(Client::class, 'id')->where(function($query) {
                    $query->where('id', $this->client_id);
                })
            ]
        ];
    }
}
