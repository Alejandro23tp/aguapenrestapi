<?php

namespace App\Rest\Controllers;

use App\Models\AsignacionPerifericos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Rest\Controller as RestController;
use App\Rest\Resources\AsignacionPerifericosResource;

class AsignacionPerifericosController extends RestController
{
    public static $resource = AsignacionPerifericosResource::class;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $asignaciones = AsignacionPerifericos::with(['equipoPrincipal', 'periferico'])->get();
        return $this->respondWithData([
            'mensaje' => 'Listado de asignaciones',
            'data' => $asignaciones,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'equipo_principal_id' => 'required|exists:equipos,id',
            'periferico_id' => 'required|exists:equipos,id',
        ]);

        $asignacion = AsignacionPerifericos::create([
            'codigo' => $request->input('codigo'),
            'equipo_principal_id' => $request->input('equipo_principal_id'),
            'periferico_id' => $request->input('periferico_id'),
        ]);

        // Cargar las relaciones después de la creación
        $asignacion->load(['equipoPrincipal', 'periferico']);
        
        return $this->respondCreated([
            'mensaje' => 'Asignación creada',
            'data' => $asignacion,
        ]);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        // Buscar el registro por ID
        $asignacion = AsignacionPerifericos::find($id);
    
        if (!$asignacion) {
            return response()->json([
                'mensaje' => 'Asignación no encontrada'
            ], Response::HTTP_NOT_FOUND);
        }
    
        // Cargar las relaciones antes de la respuesta
        $asignacion->load(['equipoPrincipal', 'periferico']);
    
        return $this->respondWithData([
            'mensaje' => 'Asignación obtenida',
            'data' => $asignacion,
        ]);
    }
    

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        // Validar la entrada
        $request->validate([
            'codigo' => 'sometimes|string|max:255',
            'equipo_principal_id' => 'sometimes|exists:equipos,id',
            'periferico_id' => 'sometimes|exists:equipos,id',
        ]);
    
        // Buscar el registro por ID
        $asignacion = AsignacionPerifericos::find($id);
    
        if (!$asignacion) {
            return response()->json([
                'mensaje' => 'Asignación no encontrada'
            ], Response::HTTP_NOT_FOUND);
        }
    
        // Actualizar los datos
        $asignacion->update($request->only(['codigo', 'equipo_principal_id', 'periferico_id']));
    
        // Cargar las relaciones después de la actualización
        $asignacion->load(['equipoPrincipal', 'periferico']);
        
        return $this->respondWithData([
            'mensaje' => 'Asignación actualizada',
            'data' => $asignacion,
        ]);
    }
    

    public function destroy(int $id): \Illuminate\Http\Response
    {
        // Buscar el registro por ID y lanzará una excepción si no se encuentra
        $asignacion = AsignacionPerifericos::findOrFail($id);
        
        // Eliminar el registro
        $asignacion->delete();
        
        // Retornar una respuesta 204 No Content
        return $this->respondNoContent();
    }
    

    /**
     * @param string $codigo
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByCodigo(string $codigo): \Illuminate\Http\JsonResponse
    {
        $asignaciones = AsignacionPerifericos::with(['equipoPrincipal', 'periferico'])
            ->where('codigo', $codigo)
            ->get();
        
        if ($asignaciones->isEmpty()) {
            return response()->json(['message' => 'No se encontraron asignaciones con el código proporcionado'], Response::HTTP_NOT_FOUND);
        }

        return $this->respondWithData([
            'mensaje' => 'Listado de asignaciones',
            'data' => $asignaciones,
        ]);
    }

    /**
     * Helper method to return a 204 No Content response.
     *
     * @return \Illuminate\Http\Response
     */
    private function respondNoContent(): \Illuminate\Http\Response
    {
        return response()->noContent();
    }

    /**
     * Helper method to return a 201 Created response with data.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondCreated($data): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * Helper method to return a JSON response with data.
     *
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithData($data): \Illuminate\Http\JsonResponse
    {
        return response()->json($data);
    }
}
