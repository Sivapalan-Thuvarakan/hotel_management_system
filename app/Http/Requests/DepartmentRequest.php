<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
    // public function rules()
    // {
    //     $id =  $this->department != null ? $this->department->id : null;
    //     return [
    //         'name' => 'required|unique:departments,name,'.$id,
    //         'parent_id' => 'nullable|exists:departments,id',
    //         "admin_id" => 'required',
    //         'description' => 'nullable'
    //     ];
    // }

    // public function messages(){
    //     return[
    //         'name.required' => 'Name is Required.',
    //         'name.unique' => 'Name should be unique.',
    //         "admin_id" => 'required',
    //     ];
    // }

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
                        'name' => 'required|unique:departments,name',
                        'parent_id' => 'nullable|exists:departments,id',
                        "admin_id" => 'required',
                        'address' => 'nullable'
                    ];
                }
            case 'PUT':
                {
                    return [
                        'name' => 'required|unique:departments,name,'.$id,
                        'parent_id' => 'nullable|exists:departments,id',
                        'address' => 'nullable'
                    ];
                }
            default:break
                ;
        }
    }
}
