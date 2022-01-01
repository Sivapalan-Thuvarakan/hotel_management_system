<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'address' => 'required'
        ];
    }

    public function messages(){
        return[
            'name.required' => 'Supplier Name is Required.',
            'phone_no.required' => 'Phone No is Required.',
            'address.required' => 'Address is Required.',
            'email.required' => 'Email is Required.'
        ];
    }
}
