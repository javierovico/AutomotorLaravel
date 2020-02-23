<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = ['venta_id','pago'];

    public function venta(){
        return $this->belongsTo('App\Venta');
    }
}
