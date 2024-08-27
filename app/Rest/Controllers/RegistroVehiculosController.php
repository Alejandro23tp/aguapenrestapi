<?php

namespace App\Rest\Controllers;

use App\Models\Registro;
use App\Models\RegistroVehiculos;
use App\Rest\Controller as RestController;
use App\Rest\Resources\RegistroVehiculosResource;
use Illuminate\Support\Facades\DB;

class RegistroVehiculosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = RegistroVehiculosResource::class;


         //Funcion para obtner el ultimo id de registro
         public function lastIdRegistroVehiculos(){
            $ultimoRegistro = RegistroVehiculos::orderBy('id', 'desc')->first();
            
            return response()->json(        
                ['id_registro_vehiculo' => $ultimoRegistro->id],
            );
        }


         // Función para obtener registros con detalles
      public function obtenerRegistrosConDetallesVehiculos()
      {
          $registrosConDetalles = DB::table('registro_vehiculos as r')
              ->join('registro_detalle_vehiculos as rd', 'r.id', '=', 'rd.id_registro_vehiculo')
              ->join('productos as p', 'rd.id_producto', '=', 'p.id')
              ->join('vehiculos as v', 'r.id_vehiculo', '=', 'v.id')
              ->select(
                  'r.id as id_tbl_registros_vehiculos',
                  'rd.id as id_tbl_registro_detalle_vehiculos',
                  'r.fecha_registro',
                  'r.hora_registro',
                  'v.placa',
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

}
