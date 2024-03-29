<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ItemRol;
use App\Models\ItemValueReport;
use App\Models\Report;

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
        $startDate = $this->date_start;
        $endDate = $this->date_end;
        $reportsCount = 0;

        if($this->action == 'edit' && !empty($startDate) && !empty($endDate)) {
            $items_values = ItemValueReport::where('report_id', $this->report_id)->get();
            $vals = [];

            #$forvaluesnotadde
            $itemseditable = ItemRol::where('rol_id', $this->rol_id)->get();

            foreach ($itemseditable as $rol) {
                foreach($rol->cols as $colss){
                    foreach ($itemseditable as $interrol) {
                        $vals[$colss->id][$interrol->id] = [
                            'value' => 0,
                            'id' => 0
                        ];
                    }
                }
            }

            foreach ($items_values as $itve) {
                $vals[$itve->item_col_id][$itve->item_rol_id] = [
                    'value' => $itve->valore,
                    'id' => $itve->id
                ];
            }

            $reportsCount = Report::where([
                ['rol_id', $this->rol_id],
                ['id', '!=', $this->report_id],
            ])->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->where([
                        ['date_start', '<=', $startDate],
                        ['date_end', '>=', $startDate],
                    ]);
                })->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where([
                        ['date_start', '<=', $endDate],
                        ['date_end', '>=', $endDate],
                    ]);
                })->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where([
                        ['date_start', '>=', $startDate],
                        ['date_end', '<=', $endDate],
                    ]);
                });
            })->count();
        } elseif ($this->action == 'create' && !empty($startDate) && !empty($endDate)) {
            $reportsCount = Report::where('rol_id', $this->rol_id)->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->where([
                        ['date_start', '<=', $startDate],
                        ['date_end', '>=', $startDate],
                    ]);
                })->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where([
                        ['date_start', '<=', $endDate],
                        ['date_end', '>=', $endDate],
                    ]);
                })->orWhere(function ($query) use ($startDate, $endDate) {
                    $query->where([
                        ['date_start', '>=', $startDate],
                        ['date_end', '<=', $endDate],
                    ]);
                });
            })->count();
        }

        //dd($reportsCount);

        if($reportsCount > 0) {
            $rule['date_start'] = 'required|date|date_format:Y-m-d|before_or_equal:date_end|starts_with:fecha';
        } else {
            $rule['date_start'] = 'required|date|date_format:Y-m-d|before_or_equal:date_end';
        }

        $rule['date_end'] = 'required|date|date_format:Y-m-d|after_or_equal:date_start';

        foreach ($items_rol as $itm) {
            foreach($itm->childs as $ch) {
                foreach ($itm->cols as $col) {
                    if('create' == 'create') {
                        $input_name = 'f_'. $this->rol_id .'_'. $col->id .'_'. $ch->id;
                    } else {
                        $input_name = 'f_'. $vals[$col->id][$ch->id]['id'];
                    }

                    if($ch->editable) {
                        $rule[$input_name] = 'required|integer';
                    }
                }

                foreach ($ch->childs as $subch) {
                    foreach ($itm->cols as $col) {
                        if('create' == 'create') {
                            $input_name = 'f_'. $this->rol_id .'_'. $col->id .'_'. $subch->id;
                        } else {
                            $input_name = 'f_'. $vals[$col->id][$subch->id]['id'];
                        }

                        $rule[$input_name] = 'required|integer';
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
            'f_*.required'           => 'Este campo es obligatorio',
            'f_*.integer'            => 'Este campo debe ser numérico',
            'date_start.starts_with' => 'El periodo no puede incluir día(s) considerado(s) en registros anteriores',
            'required'               => 'El campo :attribute es obligatorio',
            'integer'                => ':attribute debe ser numérico',
            'after_or_equal'         => ':attribute debe ser una fecha posterior o igual a :date',
            'before_or_equal'        => ':attribute debe ser una fecha anterior o igual a :date',
            'date'                   => ':attribute no es una fecha válida',
            'date_format'            => ':attribute no corresponde al formato AAAA-MM-DD',
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
