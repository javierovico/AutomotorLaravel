<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = ['marca','modelo','anho','tipo','precio','kilometros','foto'];
}
