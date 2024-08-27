<?php

namespace App\Rest\Controllers;

use App\Models\Permisos;
use App\Rest\Controller as RestController;
use App\Rest\Resources\PermisosResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = PermisosResource::class;


    // Obtener todos los permisos de un usuario
    public function getPermisosByUser($userId)
{
    $permisos = DB::table('permisos')
        ->join('opciones', 'permisos.opcion_id', '=', 'opciones.id')
        ->join('menus', 'opciones.menu_id', '=', 'menus.id')
        ->join('modulos', 'menus.modulo_id', '=', 'modulos.id')
        ->select(
            'modulos.nombre_modulo',
            'modulos.id AS modulo_id',
            'menus.nombre_menu',
            'opciones.id AS opcion_id',
            'opciones.label AS opcion_label',
            'opciones.icon AS opcion_icon',
            'opciones.routerLink AS opcion_routerLink',
            'permisos.id AS permiso_id',
            'permisos.per_ver',
            'permisos.per_editar'
        )
        ->where('permisos.user_id', $userId)
        ->orderBy('modulos.nombre_modulo')
        ->orderBy('menus.nombre_menu')
        ->orderBy('opciones.label')
        ->get();

    return response()->json([
        'message' => 'Datos obtenidos exitosamente',
        'data' => $permisos,
    ]);
}



    // Obtener todos los permisos 
    public function getAllPermisos()
{
    $permisos = DB::table('permisos')
        ->join('opciones', 'permisos.opcion_id', '=', 'opciones.id')
        ->join('menus', 'opciones.menu_id', '=', 'menus.id')
        ->join('modulos', 'menus.modulo_id', '=', 'modulos.id')
        ->select(
            'modulos.nombre_modulo',
            'menus.nombre_menu',
            'opciones.label AS opcion_label',
            'opciones.icon AS opcion_icon',
            'opciones.routerLink AS opcion_routerLink',
            'permisos.per_ver',
            'permisos.per_editar'
        )
        ->orderBy('modulos.nombre_modulo')
        ->orderBy('menus.nombre_menu')
        ->orderBy('opciones.label')
        ->get();

    return response()->json([
        'message' => 'Datos obtenidos exitosamente',
        'data' => $permisos,
    ]);
}


}
