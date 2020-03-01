<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public static $ROL_VISITANTE_ID = 4;
    protected $fillable = ['nombre'];

    public function permisos(){
        return $this->belongsToMany('App\Permiso');
    }
}
