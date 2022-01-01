<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomReservationRequest extends FormRequest
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
        $id = $this->route('reservation') != null ? $this->route('reservation')->id  : '';
        switch($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'customer_id' => 'required|exists:customers,id',
                        'from_date' => 'required',
                        'to_date' => 'required',
                        'room_type_id' => 'required',
                        'room_id' => 'required',
                        'hotel_payment' => 'nullable',
                        'payment_received' => 'required',
                    ];
                }
            case 'PUT':
                {
                    return [
                        'amount_received' => 'required',
                    ];
                }
            default:break
                ;
        }
    }
}
