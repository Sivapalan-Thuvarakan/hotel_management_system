<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
        $id = $this->route('room') != null ? $this->route('room')->id  : '';
        switch($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'room_type_id' => 'required|exists:room_types,id',
                        "description" => 'nullable',
                    ];
                }
            case 'PUT':
                {
                    return [
                        'room_type_id' => 'required|exists:room_types,id',
                        "description" => 'nullable',
                    ];
                }
            default:break
                ;
        }
    }
}
