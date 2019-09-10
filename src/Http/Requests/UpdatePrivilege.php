<?php

namespace BajakLautMalaka\PmiAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrivilege extends FormRequest
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
            'name'=>'unique:privileges,name,'.$this->privileges->id,
            'privilege_category_id'=>'exists:privilege_categories',
        ];
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'privilege_category_id.required' => 'Select at least one category for this privilege',
        ];
    }
}
