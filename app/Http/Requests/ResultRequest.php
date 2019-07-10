<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
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
        if($this->action == 'edit') {
            return [
                'theme_result'       => 'required|max:255',
                'description'        => 'max:255',
            ];
        } else {
            return [
                'rol_id'             => 'required',
                'theme_result'       => 'required|max:255',
                'description'        => 'max:255',
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'max'      => 'El campo :attribute no debe ser mayor a :max caracteres',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'rol_id'       => 'Unidad Administrativa Responsable',
            'theme_result' => 'Tema',
            'description'  => 'Descripción',
        ];
    }
}