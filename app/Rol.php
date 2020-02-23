<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = ['nombre'];

    public function permisos(){
        return $this->belongsToMany('App\Permiso');
    }
}
