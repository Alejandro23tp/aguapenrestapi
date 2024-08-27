<?php

namespace App\Rest\Controllers;

use App\Models\Inventario;
use App\Rest\Controller as RestController;
use App\Rest\Resources\InventarioResource;

class InventariosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource =InventarioResource::class;

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = Inventario::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
