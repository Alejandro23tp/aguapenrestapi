<?php

namespace App\Rest\Controllers;

use App\Models\ContadorReportes;
use App\Rest\Controller as RestController;
use App\Rest\Resources\ContadorReportesResource;

class ContadorReportesController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = ContadorReportesResource::class;


    
}
