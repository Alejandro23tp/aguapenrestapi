<?php

namespace App\Rest\Controllers;

use App\Models\Registro;
use App\Models\RegistroArea;
use App\Rest\Controller as RestController;
use App\Rest\Resources\RegistroAreaResource;
use Illuminate\Support\Facades\DB;

class RegistroAreaController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = RegistroAreaResource::class;


    public function countareas(){
        $countareas = DB::table('areas')->count();
        return response()->json(        
            ['data' => $countareas],
        );
    }


     //Funcion para obtner el ultimo id de registro
     public function lastIdRegistroArea(){
        $ultimoRegistro = RegistroArea::orderBy('id', 'desc')->first();
        
        return response()->json(        
            ['id_registro_area' => $ultimoRegistro->id],
        );
    }

      // Función para obtener registros con detalles
      public function obtenerRegistrosConDetallesArea()
      {
          $registrosConDetalles = DB::table('registro_areas as r')
              ->join('registro_detalle_areas as rd', 'r.id', '=', 'rd.id_registro_area')
              ->join('productos as p', 'rd.id_producto', '=', 'p.id')
              ->join('areas as a', 'r.id_area', '=', 'a.id')
              ->select(
                  'r.id as id_tbl_registros_areas',
                  'rd.id as id_tbl_registro_detalle_areas',
                  'r.fecha_registro',
                  'r.hora_registro',
                  'a.nombre_area',
                  'p.id as id_tbl_productos',
                  'p.nombre_producto',
                  'p.codigo_producto',
                  'p.stock_producto',
                  'rd.cantidad',
                  'r.observacion',
                  'r.estado_registro',
                  DB::raw('SUM(rd.cantidad) OVER (PARTITION BY r.id) AS total_cantidades')
              )
              ->orderBy('r.id')
              ->orderBy('p.nombre_producto')
              ->get();
  
          return response()->json(['data' => $registrosConDetalles]);
      }

      /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = RegistroArea::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
   
}
