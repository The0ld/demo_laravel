<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class PaqueryRequest extends FormRequest
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
            'schedule_origin' => ['required'],
            'schedule_origin.shipping_address' => ['required', 'string', 'max:191'],
            'schedule_destination' => ['required'],
            'schedule_destination.shipping_address' => ['required', 'string', 'max:191'],
        ];
    }
}
