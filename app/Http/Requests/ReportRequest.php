<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ItemRol;

class ReportRequest extends FormRequest
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
        //dd($this->request->all());
        $items_rol = ItemRol::where('rol_id', $this->rol_id)->where('parent_id', null)->get();
        $rule = [
            'date_start' => 'required|date|date_format:Y-m-d|before_or_equal:date_end',
            'date_end' => 'required|date|date_format:Y-m-d|after_or_equal:date_start',
        ];

        foreach ($items_rol as $itm) {
            foreach($itm->childs as $ch) {
                foreach ($itm->cols as $col) {
                    if($ch->editable) {
                        $rule['f_'. $this->rol_id .'_'. $col->id .'_'. $ch->id] = 'required|integer';
                    }
                }

                foreach ($ch->childs as $subch) {
                    foreach ($itm->cols as $col) {
                        $rule['f_'. $this->rol_id .'_'. $col->id .'_'. $subch->id] = 'required|integer';
                    }
                }
            }
        }

        return $rule;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'required'          => 'El campo :attribute es obligatorio',
            'integer'           => ':attribute debe ser numérico',
            'after_or_equal'    => ':attribute debe ser una fecha posterior o igual a :date',
            'before_or_equal'   => ':attribute debe ser una fecha anterior o igual a :date',
            'date'              => ':attribute no es una fecha válida',
            'date_format'       => ':attribute no corresponde al formato :format',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'date_start' => 'Fecha Inicio',
            'date_end' => 'Fecha Fin',
        ];
    }
}
