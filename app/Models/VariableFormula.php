<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ItemValueReport;

class VariableFormula extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];

      public function rows(){
      	return $this->hasMany('App\Models\ItemRol','id','itemrol_id');
      }

      public function cols(){
      	return $this->hasMany('App\Models\RolStructureItem','id','itemstructure_id');
      }






  protected $fillable = [
    'formula_id','itemrol_id',
    'itemstructure_id'
  ];

}
