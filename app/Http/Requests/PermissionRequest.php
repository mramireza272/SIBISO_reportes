<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
    public function rules() {
        return [
            'name'        => 'required|max:255',
            'description' => 'max:255',
        ];
    }

    public function messages() {
        return [
            'name.required'   => 'El Nombre del Permiso es obligatorio',
            'description.max' => 'La Descripción del Permiso no debe ser mayor a :max caracteres',
            'max'             => 'El Nombre del Permiso no debe ser mayor a :max caracteres',
        ];
    }
}
