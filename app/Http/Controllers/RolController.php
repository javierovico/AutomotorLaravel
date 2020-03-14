<?php

namespace App\Http\Controllers;

use App\User;
use \Exception;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function cambiarRol(Request $request){
        try{
            $request->validate([
                'userId'     => 'required|integer',
                'nuevoRol'      => 'required|integer',
            ]);
            $usuarioCambio = User::where('id',$request->userId)->first();
            $usuarioCambio->rol_id = $request->nuevoRol;
            $usuarioCambio->save();
        }catch (Exception $exception){
            return response()->json([
                'error' => 'No se pudo crear'], 401);
        }
        return response()->json([
            'message' => 'Successfully created user!'], 200);
    }
}
