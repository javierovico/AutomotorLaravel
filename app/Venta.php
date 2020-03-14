<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['vehiculo_id','comprador_id','vendedor_id'];

    public function vendedor(){
        return $this->belongsTo('App\User','id','vendedor_id');
    }

    public function comprador(){
        return $this->belongsTo('App\User','id','comprador_id');
    }

    public function vehiculo(){
        return $this->belongsTo('App\Vehiculo');
    }

    public function facturas(){
        return $this->hasMany('App\Factura');
    }
}
