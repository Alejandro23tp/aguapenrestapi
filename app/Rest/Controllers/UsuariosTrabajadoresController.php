<?php

namespace App\Rest\Controllers;

use App\Models\Usuarios;
use App\Models\UsuariosTrabajadores;
use App\Rest\Controller as RestController;
use App\Rest\Resources\UsuariosTrabajadoresResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosTrabajadoresController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = UsuariosTrabajadoresResource::class;


  
    public function countUsersWorkers(){
        $countusers = DB::table('usuarios_trabajadores')->count();
        return response()->json(        
            ['data' => $countusers],
        );
    }

    // Obtener todos los usuarios
    public function getAllUsuariosTrabajadores(Request $request)
    {
         $usuarios = DB::table('usuarios_trabajadores')->get();
 
         return response()->json([
             'message' => 'Datos obtenidos exitosamente',
             'data' => $usuarios,
         ]);
     }

     /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = UsuariosTrabajadores::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
