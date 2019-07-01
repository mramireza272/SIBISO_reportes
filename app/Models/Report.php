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
        'active'
    ];

    public function childs(){
        return $this->hasMany('App\Models\ItemValueReport', 'report_id', 'id');
    }
}
