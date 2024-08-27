<?php

namespace App\Rest\Controllers;

use App\Models\RegistroDetalleVehiculos;
use App\Rest\Controller as RestController;
use App\Rest\Resources\RegistroDettaleVehiculosResource;

class RegistroDetalleVehiculosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = RegistroDettaleVehiculosResource::class;

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = RegistroDetalleVehiculos::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
