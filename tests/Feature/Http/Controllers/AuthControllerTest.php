<?php

namespace Tests\Feature\Http\Controllers;

use App\Rol;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase{

    public function test_crear_usuario_sin_datos(){
        $response = $this->post('api/auth/signup',[]);
        $response->assertStatus(422);
    }

    /**
     * prueba con:
     * api/auth/signup
     * api/auth/login
     * api/auth/user
     * @return int el id del usuario creado
     */
    public function test_crear_usuario_normal(){
        $numeroAleatorio = date("Ymdhis");
        $correo = 'user.'.$numeroAleatorio.'@aldo.com';
        $password = 'p'.$numeroAleatorio;
        $usuario = new User([
            'name' => 'user_'.$numeroAleatorio,
            'email' => $correo,
            'password'  =>  $password,
            'apellido'  =>  'ape_'.$numeroAleatorio,
            'documento'    =>  $numeroAleatorio,
            'telefono'  =>  '0971'.$numeroAleatorio,
            'rol_id'    =>  Rol::$ROL_VISITANTE_ID
        ]);
        return $this->crear_usuario($usuario);
    }

    public function test_cambiar_rol(){
        $usuarioNuevoId = $this->test_crear_usuario_normal();
        $this->cambiar_rol($usuarioNuevoId,$usuarioNuevoId,false);
    }

    /**
     * @param int $admin el que propicia el cambio de usuario
     * @param int $user el usuario que sufre el cambio
     * @param bool $resultadoEsperado el resultado de la operacion que se quieri
     */
    public function cambiar_rol(int $admin, int $user, bool $resultadoEsperado){
        $usuarioAdmin = User::where('id',$admin)->first();
        $tokenAdmin = $this->iniciar_usuario($usuarioAdmin);
        $response = $this->post('editar-rol',[
            ''
        ]);
    }

    /**
     * @param User $usuario
     * @return int el id del usuario creado
     */
    public function crear_usuario(User $usuario){
        $response = $this->post('api/auth/signup',[
            'name' => $usuario->name,
            'email' => $usuario->email,
            'password'  =>  $usuario->password,
            'password_confirmation' =>  $usuario->password,
            'apellido'  =>  $usuario->apellido,
            'documento'    =>  $usuario->documento,
            'telefono'  =>  $usuario->telefono
        ]);
        $response->assertStatus(200);
        $nuevoToken = $this->iniciar_usuario($usuario);
        $respuestaJson = $this->ver_usuario_token($nuevoToken);
        assert($respuestaJson->email == $usuario->correo);
        return $respuestaJson->id;
    }

    /**
     * @param User $user
     * @return string
     */
    public function iniciar_usuario(User $user){
        $response = $this->post('api/auth/login',[
            'email' =>  $user->email,
            'password'  =>  $user->password
        ]);
        $response->assertStatus(200);
        $respuesta = json_decode($response->getContent());
        assert($respuesta->rol_id == $user->rol_id,'el nuevo rol tiene que ser otro');
        $nuevoToken = $respuesta->access_token;
        assert(strlen($nuevoToken)>30,'el token esta incompleto');
        return $nuevoToken;
    }

    /**
     * @param string $nuevoToken
     * @return object
     */
    public function ver_usuario_token(string $nuevoToken){
        $response = $this->get('api/auth/user',[
            'HTTP_Authorization'    =>  'Bearer '.$nuevoToken
        ]);
        $response->assertStatus(200);
        return (object)json_decode($response->getContent());
    }

}
