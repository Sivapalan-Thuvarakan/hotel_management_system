<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'product_name' => 'required',
            'brand' => 'required',
            'type' => 'required',
            'description' => 'required',
            'purchase_price' => 'required',
            'quantity' => 'required',
            'supplier' => 'required',
        ];
    }

    public function messages(){
        return[
            'product_name.required' => 'Product Name is Required.',
            'brand.required' => 'Brand is Required.',
            'Type.required' => 'Type is Required.',
            'description.required' => 'Description is Required.',
            'purchase_price.required' => 'Purchase price is Required.',
            'quantity.required' => 'Quantity is Required.',
            'supplier.required' => 'Supplier is Required.',
        ];
    }
}
