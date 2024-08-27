<?php

namespace App\Rest\Controllers;

use App\Models\RegistroDetalleAreas;
use App\Rest\Controller as RestController;
use App\Rest\Resources\RegistroDettaleAreasResource;

class RegistroDetalleAreasController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = RegistroDettaleAreasResource::class;
    
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = RegistroDetalleAreas::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
