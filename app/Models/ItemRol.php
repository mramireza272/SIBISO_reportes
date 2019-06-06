<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemRol extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    public function childs(){
    	return $this->hasMany('App\Models\ItemRol','parent_id','id')->orderBy('order');
    }

    public function cols(){
    	return $this->hasMany('App\Models\RolStructureItem','item_rol_id','id')->orderBy('order');
    }



}
