<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function goals(){
    	return $this->hasMany('App\Models\Goal','result_id','id');
    }

    public function formulas(){
    	return $this->hasMany('App\Models\FormulaResult','result_id','id');
    }



    protected $fillable = [
      'rol_id','theme_result'
    ];






}
