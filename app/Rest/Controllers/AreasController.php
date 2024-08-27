<?php

namespace App\Rest\Controllers;

use App\Models\Areas;
use App\Rest\Controller as RestController;
use App\Rest\Resources\AreasResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreasController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = AreasResource::class;


    // Obtener todos los areas
    public function  getAllAreas(Request $request)
    {
         $areas = DB::table('areas')->get();
 
         return response()->json([
             'message' => 'Datos obtenidos exitosamente',
             'data' => $areas,
         ]);
     }


     public function countAreas(){
        $countareas = DB::table('areas')->count();
        return response()->json(        
            ['data' => $countareas],
        );
    }
    
}
