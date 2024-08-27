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
    

}
