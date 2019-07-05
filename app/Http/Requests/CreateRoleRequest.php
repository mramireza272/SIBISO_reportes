<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'name' => 'required|max:255',
            'permissions' => 'required'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'El Nombre del Rol es obligatorio',
            'permissions.required' => 'Debe seleccionar al menos un permiso',
            'max' => 'El Nombre del Rol no debe ser mayor a :max caracteres',
        ];
    }
}
