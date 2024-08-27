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
 
}
