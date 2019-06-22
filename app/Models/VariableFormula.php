<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ItemValueReport;

class VariableFormula extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];






  protected $fillable = [
    'formula_id','itemrol_id',
    'itemstructure_id'
  ];

}
