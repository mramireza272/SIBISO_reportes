<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'rol_id',
        'created_by',
        'date_start',
        'date_end',
        'observation',
        'active',
        'status',
        'authorized_by',
        'updated_at'
    ];

    public function childs(){
        return $this->hasMany('App\Models\ItemValueReport', 'report_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'created_by', 'id')->orderBy('name');
    }

    public function authorize(){
        return $this->belongsTo('App\User', 'authorized_by', 'id')->orderBy('name');
    }
}
