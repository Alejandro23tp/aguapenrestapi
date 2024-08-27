<?php

namespace App\Rest\Controllers;

use App\Models\Registro;
use App\Rest\Controller as RestController;
use App\Rest\Resources\RegistroResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegistroController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = RegistroResource::class;


    //Funcion para obtener el ultimo id de registro
    public function ultimoIdRegistro(){
        $ultimoRegistro = Registro::orderBy('id', 'desc')->first();
        
        return response()->json(        
            ['id_registro' => $ultimoRegistro->id],
        );
    }


    
     // Función para obtener los registros con detalles
     public function obtenerRegistrosConDetalles()
     {
         $registrosConDetalles = DB::table('registros as r')
             ->join('usuarios_trabajadores as u', 'r.id_usuario', '=', 'u.id')
             ->join('registro_detalles as rd', 'r.id', '=', 'rd.id_registro')
             ->join('productos as p', 'rd.id_producto', '=', 'p.id')
             ->select(
                 'r.id as id_tbl_registros',
                 'rd.id as id_tbl_registro_detalles',
                 'u.tx_nombre as nombre',
                 'u.tx_cedula as cedula',
                 'u.tx_cargo as cargo',
                 'r.fecha_registro',
                 'p.id as id_tbl_productos',
                 'p.nombre_producto',
                 'p.codigo_producto',
                 'p.stock_producto',
                 'rd.cantidad',
                 'r.observacion',
                 'r.estado_registro',
                 'r.imagen',
                 DB::raw('SUM(rd.cantidad) OVER (PARTITION BY r.id) AS total_cantidades')
             )
             ->orderBy('r.id')
             ->orderBy('p.nombre_producto')
             ->get();
 
         return response()->json(
             ['data' => $registrosConDetalles],
         );
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
     $registro = Registro::find($id);
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

 /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = Registro::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
