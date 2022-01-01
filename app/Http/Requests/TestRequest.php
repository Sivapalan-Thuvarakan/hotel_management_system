<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
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
        $id =  $this->test != null ? $this->test->id : null;
        return [
            'name' => 'required|unique:tests,name,'.$id,
            'description' => 'nullable'
        ];
    }

    public function messages(){
        return[
            'name.required' => 'Name is Required.',
            'name.unique' => 'Name should be unique.'
        ];
    }
}
