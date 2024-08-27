<?php

namespace App\Rest\Controllers;

use App\Models\Vehiculos;
use App\Rest\Controller as RestController;
use App\Rest\Resources\VehiculosResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = VehiculosResource::class;


      // Obtener todos los productos
      public function  getAllVehiculos(Request $request)
      {
           $products = DB::table('vehiculos')->get();
   
           return response()->json([
               'message' => 'Datos obtenidos exitosamente',
               'data' => $products,
           ]);
       }

}
