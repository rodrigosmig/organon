<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectFormRequest extends FormRequest
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
            'name'              => 'required|min:5',
            'deadline'          => 'required|date|after:today',
            'client'            => 'required',
        ];
    }

    public function all($keys = null)
    {
        $attributes = parent::all();
        
        if (isset($attributes['amount_charged'])) {
            $amount_charged = (float) str_replace(',', '.', $attributes['amount_charged']);
            $attributes['amount_charged'] = $amount_charged;
        }

        return $attributes;
    }
}
