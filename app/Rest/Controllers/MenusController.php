<?php

namespace App\Rest\Controllers;

use App\Models\Menus;
use App\Rest\Controller as RestController;
use App\Rest\Resources\MenusResource;

class MenusController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = MenusResource::class;

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = Menus::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
