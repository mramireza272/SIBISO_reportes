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
            'date_start'     => 'required|date|date_format:Y-m-d|before_or_equal:date_end',
            'date_end'       => 'required|date|date_format:Y-m-d|after_or_equal:date_start',
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
            'integer'              => 'El campo :attribute debe ser un número entero',
            'after_or_equal'       => ':attribute debe ser una fecha posterior o igual a :date',
            'before_or_equal'      => ':attribute debe ser una fecha anterior o igual a :date',
            'date'                 => ':attribute no es una fecha válida',
            'date_format'          => ':attribute no corresponde al formato AAAA-MM-DD',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'goal_txt'   => 'Nombre',
            'goal_unit'  => 'Unidad',
            'date_start' => 'Fecha Inicio',
            'date_end'   => 'Fecha Fin',
        ];
    }
}
