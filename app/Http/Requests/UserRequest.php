<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name'       => 'required|max:255',
            'paterno'    => 'max:255',
            'materno'    => 'max:255',
            'email'      => 'required|email|same:email_confirmation|max:255',
            'password'   => 'required|same:password_confirmation',
            'roles'      => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'password.required' => 'La Contraseña es obligatoria',
            'required'          => 'El :attribute es obligatorio',
            'same'              => ':attribute y :other deben coincidir',
            'max'               => 'El :attribute no debe ser mayor a :max caracteres',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'name'                  => 'Nombre',
            'paterno'               => 'Apellido Paterno',
            'materno'               => 'Apellido Materno',
            'email'                 => 'Correo Personal',
            'email_confirmation'    => 'Confirmar Correo Personal',
            'password'              => 'Contraseña',
            'password_confirmation' => 'Confirmación de Contraseña',
            'roles'                 => 'Rol',
        ];
    }
}
