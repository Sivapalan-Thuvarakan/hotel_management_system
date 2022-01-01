<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeRequest extends FormRequest
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
        $id = $this->route('room_type') != null ? $this->route('room_type')->id  : '';
        switch($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'name' => 'required|unique:room_types,name',
                        'rental_price' => 'required',
                        'reservation_fee_percentage' => 'required',
                        "description" => 'nullable',
                    ];
                }
            case 'PUT':
                {
                    return [
                        'name' => 'required|unique:room_types,name,'.$id,
                        'rental_price' => 'required',
                        'reservation_fee_percentage' => 'required',
                        "description" => 'nullable',
                    ];
                }
            default:break
                ;
        }
    }
}
