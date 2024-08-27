<?php

namespace App\Rest\Controllers;

use App\Models\Productos;
use App\Rest\Controller as RestController;
use App\Rest\Resources\ProductosResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = ProductosResource::class;


    // Obtener todos los productos
    public function  getAllProductos(Request $request)
    {

         $products = Productos::all();

         return response()->json([
             'message' => 'Datos obtenidos exitosamente',
             'data' => $products,
         ]);
     }

    //Funcio para saber cuantos usuarios trabajadores hay en la base de datos
    public function countProducts(){
        $countproducts = DB::table('productos')->count();
        return response()->json(        
            ['data' => $countproducts],
        );
    }


}
