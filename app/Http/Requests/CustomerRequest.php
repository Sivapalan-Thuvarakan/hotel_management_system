<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $id =  $this->customer != null ? $this->customer->id : null;
        return [
            
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'nullable',
                'phone_no' => 'required',
                'address' => 'required',
                'national_id' => 'required|unique:customers,national_id',
        ];
    }

    public function messages(){
        return[
            'fname.required' => 'Full Name is Required.',
            'lname.required' => 'Last Name is Required.',
            'phone_no.required' => 'Phone No is Required.',
            'address.required' => 'Address is Required.',
            'national_id.unique' => 'National ID should be unique.',
            'national_id.required' => 'National ID is Required.'
        ];
    }
}
