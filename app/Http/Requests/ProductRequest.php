<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'selling_price' => 'required',
            'discount' => 'required',
        ];
    }

    public function messages(){
        return[
            'selling_price.required' => 'selling is Required.',
            'discount.required' => 'Discount is Required.',
        ];
    }
}
