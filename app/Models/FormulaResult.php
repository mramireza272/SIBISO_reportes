<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormulaResult extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];



      public function variables(){
      	return $this->hasMany('App\Models\VariableFormula','formula_id','id');
      }




  protected $fillable = [
    'result_id','formula'
  ];


}
