<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = ['venta_id','vencimiento','deuda'];

    public function venta(){
        return $this->belongsTo('App\Venta');
    }
}
