<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $caracteristicaVehiculo = ['marca','modelo','anho','tipo'];
            $table->bigIncrements('id');
            foreach ($caracteristicaVehiculo as $item) {
                $table->string($item);
            }
            $table->unsignedInteger('precio');
            $table->unsignedInteger('kilometros');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
