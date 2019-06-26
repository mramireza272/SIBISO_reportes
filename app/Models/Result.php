<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
      'rol_id', 'theme_result'
    ];


    public function goals(){
    	return $this->hasMany('App\Models\Goal', 'result_id','id');
    }

    public function formulas(){
    	return $this->hasMany('App\Models\FormulaResult', 'result_id','id');
    }

    public function rol(){
        return $this->belongsTo('Spatie\Permission\Models\Role', 'rol_id', 'id');
    }
}