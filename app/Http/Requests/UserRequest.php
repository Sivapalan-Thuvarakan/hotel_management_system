<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = $this->route('id');

        switch($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'name' => 'required|max:100',
                        'email' => 'required|email|unique:users,email|max:100',
                        'role' => 'required|not_in:1',
                        'nic_no' => 'nullable|max:100',
                        'password' => 'required|min:8',
                    ];
                }
            case 'PUT':
                {
                    return [
                        'name' => 'required|max:100',
                        'nic_no' => 'nullable|max:100',
                        'permissions[]' => 'nullable',
                    ];
                }
            default:break
                ;
        }
    }
}
