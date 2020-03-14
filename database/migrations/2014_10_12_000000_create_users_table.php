<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('documento')->unique();
            $table->string('name');
            $table->string('apellido');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telefono');
            $table->unsignedBigInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('rols');
            $table->rememberToken();
            $table->timestamps();
        });
        //inicializacion de valores por defecto
        $permisos = [
            1=>     'ver_propio_perfil',
            2=>     'ver_otros_perfiles',
            9=>     'crear_perfil',
            3=>     'editar_rol_usuario',
            4=>     'registrar_venta',
            5=>     'ver_productos',
            6=>     'crear_producto',
            7=>     'registrar_pago',
            8=>     'solicitar_vendedor'
        ];
        $roles = [
            'admin'     =>  [1,2,3,5,6,9],
            'vendedor'  =>  [1,4,5],
            'cajero'    =>  [1,7],
            'comprador' =>  [1,5,8],
            'visitante' =>  [5]
        ];
        $rolAdminId = null;
        foreach ($permisos as $id=>$permiso) {
            DB::table('permisos')->insert([
                'id'        =>  $id,
                'nombre'    =>  $permiso
            ]);
        }
        foreach ($roles as $nombre=>$permisos){
            $rolId = DB::table('rols')->insertGetId([
                'nombre'    =>  $nombre
            ]);
            if(!$rolAdminId){   //el primer rol es el admin, este es su id
                $rolAdminId = $rolId;
            }
            foreach ($permisos as $permisoId) {
                DB::table('permiso_rol')->insert([
                    'permiso_id'    =>  $permisoId,
                    'rol_id'        =>  $rolId
                ]);
            }
        }
        // crear el usuario admin
        DB::table('users')->insert([
            'email'     =>  'admin@automotor.com.py',
            'documento' =>  1,
            'name'      =>  'admin',
            'apellido'  =>  'admin',
            'password'  =>  bcrypt('adm1n'),
            'telefono'  =>  '1',
            'rol_id'    =>  $rolAdminId
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
