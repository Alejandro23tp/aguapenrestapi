<?php

namespace App\Rest\Controllers;

use App\Models\Equipos;
use App\Rest\Controller as RestController;
use App\Rest\Resources\EquiposResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EquiposController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = EquiposResource::class;

    public function equiposprincipales()
    {
        $equiposPrincipales = Equipos::where('es_periferico', false)->get();
    
        return response()->json([
            'mensaje' => 'Listado de equipos principales',
            'data' => $equiposPrincipales,
        ]);
    }
    
    public function equiposperifericos()
    {
        $equiposPerifericos = Equipos::where('es_periferico', true)->get();
    
        return response()->json([
            'mensaje' => 'Listado de equipos perifericos',
            'data' => $equiposPerifericos,
        ]);
    }

    public function obtenerEquiposxId(Request $request){
        $data = Equipos::where('id', $request->id)->get();
        return response()->json([
            'mensaje' => 'Listado de equipos',
            'data' => $data,
        ]);
    }


     // La función para subir la imagen
    public function subirImagen(Request $request, $id)
    {
        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Buscar el registro
        $registro = Equipos::find($id);
        if (!$registro) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        // Manejar la imagen
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/imagenes', $filename);

            // Actualizar el registro con la ruta de la imagen
            $registro->imagen = Storage::url($path);
            $registro->save();

            return response()->json(['success' => 'Imagen subida correctamente', 'ruta_imagen' => $registro->imagen], 200);
        }

        return response()->json(['error' => 'No se pudo subir la imagen'], 500);
    }


    
}