<?php

use App\Rest\Controllers\AreasController;
use App\Rest\Controllers\AsignacionPerifericosController;
use App\Rest\Controllers\ContadorReportesController;
use App\Rest\Controllers\EquiposController;
use App\Rest\Controllers\MenusController;
use App\Rest\Controllers\ModulosController;
use App\Rest\Controllers\OpcionesController;
use App\Rest\Controllers\PermisosController;
use App\Rest\Controllers\ProductosController;
use App\Rest\Controllers\RegistroAreaController;
use App\Rest\Controllers\RegistroController;
use App\Rest\Controllers\RegistroDetalleAreasController;
use App\Rest\Controllers\RegistroDetalleController;
use App\Rest\Controllers\RegistroDetalleVehiculosController;
use App\Rest\Controllers\RegistroVehiculosController;
use App\Rest\Controllers\RolesController;
use App\Rest\Controllers\UserController;
use App\Rest\Controllers\UsuariosTrabajadoresController;
use App\Rest\Controllers\VehiculosController;
use Illuminate\Support\Facades\Route;
use Lomkit\Rest\Facades\Rest;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

//Rutas de Laravel Rest API CRUD Create, Read, Update, Delete
Rest::resource('productos', ProductosController::class);
Rest::resource('usuariostrabajadores', UsuariosTrabajadoresController::class);
Rest::resource('registros', RegistroController::class);
Rest::resource('registrosdetalle', RegistroDetalleController::class);
Rest::resource('roles', RolesController::class);
Rest::resource('areas', AreasController::class);
Rest::resource('registroareas', RegistroAreaController::class);
Rest::resource('registrodetalleareas', RegistroDetalleAreasController::class);
Rest::resource('vehiculos', VehiculosController::class);
Rest::resource('registrovehiculos', RegistroVehiculosController::class);
Rest::resource('registrodetallevehiculos', RegistroDetalleVehiculosController::class);
Rest::resource('users', UserController::class);
Rest::resource('contador', ContadorReportesController::class);
Rest::resource('modulos', ModulosController::class);
Rest::resource('menus', MenusController::class);
Rest::resource('opciones', OpcionesController::class);
Rest::resource('permisos', PermisosController::class);
//P2
Rest::resource('equipos', EquiposController::class);
Rest::resource('asignacionperifericos', AsignacionPerifericosController::class);


Route::post('login', [UserController::class, 'login']);
Route::post('/resetpassword', [UserController::class, 'resetPasswordByCedula']);
Route::post('/verifycedula', [UserController::class, 'verifyCedula']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('allusers', [UserController::class, 'AllUsers']);
    Route::get('user', [UserController::class, 'show']);
    Route::get('allusersworkers', [UsuariosTrabajadoresController::class, 'getAllUsuariosTrabajadores']);

});

//Obtener todos los datos
//Route::get('/allproducts', [ProductosController::class, 'getAllProductos']);
Route::get('/allareas', [AreasController::class, 'getAllAreas']);
Route::get('/allvehiculos', [VehiculosController::class, 'getAllVehiculos']);
Route::get('allproducts', [ProductosController::class, 'getAllProductos']);
Route::get('allmodulos', [ModulosController::class, 'getModulosWithMenusAndOpciones']);
//Obtener cantidad de datos
Route::get('/countusersworkers', [UsuariosTrabajadoresController::class, 'countUsersWorkers']);
Route::get('/countproducts', [ProductosController::class, 'countProducts']);
Route::get('/countareas', [AreasController::class, 'countAreas']);



//Ultimo id de registro
Route::get('/idlastregistro', [RegistroController::class, 'ultimoIdRegistro']);

//Ultimo id de registro de area
Route::get('/idlastregistroarea', [RegistroAreaController::class, 'lastIdRegistroArea']);

//Ultimo id de registro de vehiculo 
Route::get('/idlastregistrovehiculos', [RegistroVehiculosController::class, 'lastIdRegistroVehiculos']);


//Obtener registros con detalles
Route::get('/obtenerRegistrosConDetalles', [RegistroController::class, 'obtenerRegistrosConDetalles']);

//Obtener registros con detalles de area
Route::get('/obtenerRegistrosConDetallesArea', [RegistroAreaController::class, 'obtenerRegistrosConDetallesArea']);

//Obtener registros con detalles de vehiculo
Route::get('/obtenerRegistrosConDetallesVehiculos', [RegistroVehiculosController::class, 'obtenerRegistrosConDetallesVehiculos']);


Route::post('registros/{id}/imagen', [RegistroController::class, 'subirImagen']);


Route::get('/permisosmenus/{userId}', [PermisosController::class, 'getPermisosByUser']);
Route::get('/permisosmenus', [PermisosController::class, 'getAllPermisos']);

//EQUIPOS
Route::get('/equiposprincipales', [EquiposController::class, 'equiposprincipales']);
Route::get('/equiposperifericos', [EquiposController::class, 'equiposperifericos']);
Route::post('/ObtenerEquiposId', [EquiposController::class, 'obtenerEquiposxId']);

//ASIGNACION PERIFERICOS
Route::get('/asignacionperifericos_listarrecursos', [AsignacionPerifericosController::class, 'index']);
Route::get('/asignacionperifericos_codigo/{codigo}', [AsignacionPerifericosController::class, 'listByCodigo']);

Route::post('/asignacionperifericos_crear', [AsignacionPerifericosController::class, 'store']);
Route::get('/asignacionperifericos_show/{id}', [AsignacionPerifericosController::class, 'show']);
Route::put('/asignacionperifericos_update/{id}', [AsignacionPerifericosController::class, 'update']);
//Route::delete('/asignacionperifericos_destroy/{id}', [AsignacionPerifericosController::class, 'destroy']);
