<?php

namespace App\Rest\Controllers;

use App\Models\Modulos;
use App\Rest\Controller as RestController;
use App\Rest\Resources\ModulosResource;
use Illuminate\Support\Facades\DB;

class ModulosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = ModulosResource::class;


    
   public function getModulosWithMenusAndOpciones(){
    $modulos = DB::table('modulos')
            ->join('menus', 'menus.modulo_id', '=', 'modulos.id')
            ->join('opciones', 'opciones.menu_id', '=', 'menus.id')
            ->select(
                'modulos.nombre_modulo',
                'menus.nombre_menu',
                'opciones.id AS opcion_id',
                'opciones.label AS opcion_label',
                'opciones.routerlink AS opcion_routerLink',
                'opciones.icon AS opcion_icon'
            )
            ->orderBy('modulos.nombre_modulo')
            ->orderBy('menus.nombre_menu')
            ->orderBy('opciones.label')
            ->get();

       
 
      return response()->json([
          'message' => 'Datos obtenidos exitosamente',
          'data' => $modulos,
      ]);
   }

   /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = Modulos::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
