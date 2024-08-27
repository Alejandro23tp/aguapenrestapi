<?php

namespace App\Rest\Controllers;

use App\Models\Mantenimiento;
use App\Rest\Controller as RestController;
use App\Rest\Resources\MantenimientoResource;

class MantenimientoController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = MantenimientoResource::class;

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = Mantenimiento::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
