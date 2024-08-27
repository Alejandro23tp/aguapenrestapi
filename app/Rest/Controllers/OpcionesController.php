<?php

namespace App\Rest\Controllers;

use App\Models\Opciones;
use App\Rest\Controller as RestController;
use App\Rest\Resources\OpcionesResource;

class OpcionesController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = OpcionesResource::class;


    
}
