<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class ManualRequest extends FormRequest
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
            'remitente' => ['required'],
            'remitente.direccion' => ['required', 'string', 'max:191'],
            'remitente.localidad' => ['required', 'string', 'max:191'],
            'remitente.provincia' => ['required', 'string', 'max:191'],
            'destinatario' => ['required'],
            'destinatario.direccion' => ['required', 'string', 'max:191'],
            'destinatario.localidad' => ['required', 'string', 'max:191'],
            'destinatario.provincia' => ['required', 'string', 'max:191']
        ];
    }
}
