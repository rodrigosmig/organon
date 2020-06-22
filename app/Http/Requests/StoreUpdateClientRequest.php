<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateClientRequest extends FormRequest
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
            'name' => "required|min:3|max:255",
            'email' => "required|email",
            'cpf_cnpj' => [
                'nullable',
                'min:11',
                'max:14',
            ],
            'postal_code' => "nullable|min:8|max:8",
            'phone' => "nullable|max:12",
            'state' => "nullable|max:2",
        ];
    }
}
