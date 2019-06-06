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
        'date_start',
        'date_end',
        'active'
    ];


}
