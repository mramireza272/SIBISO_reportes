<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalRequest extends FormRequest
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
            'goal_txt'       => 'required|max:255',
            'goal_unit'      => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'required'             => 'El campo :attribute es obligatorio',
            'max'                  => 'El campo :attribute no debe ser mayor a :max caracteres',
            'integer'              => 'El campo :attribute debe ser un número entero.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'goal_txt' => 'Nombre',
            'goal_unit' => 'Unidad',
        ];
    }
}
