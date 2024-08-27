<?php

namespace App\Rest\Controllers;

use App\Models\Roles;
use App\Rest\Controller as RestController;
use App\Rest\Resources\RolesResource;

class RolesController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = RolesResource::class;

 
}
