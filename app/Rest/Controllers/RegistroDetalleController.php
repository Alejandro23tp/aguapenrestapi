<?php

namespace App\Rest\Controllers;

use App\Models\RegistroDetalle;
use App\Rest\Controller as RestController;
use App\Rest\Resources\RegistroDetalleResource;

class RegistroDetalleController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = RegistroDetalleResource::class;

}
