<?php

namespace BajakLautMalaka\PmiAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminPrivilege extends FormRequest
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
            'admin_id'=>'exists:admins',
            'privilege_id'=>'exists:privileges',
        ];
    }
    
}
