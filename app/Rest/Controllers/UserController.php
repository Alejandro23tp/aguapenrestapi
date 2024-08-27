<?php

namespace App\Rest\Controllers;

use App\Models\User;
use App\Rest\Controller as RestController;
use App\Rest\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = UserResource::class;


    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);


        $user = User::where('usuario', $request->usuario)->first();


        if (!$user) {
            return response()->json([
                'message' => 'El usuario no existe.',
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Contraseña incorrecta.',
            ], 401);
        }

        return response()->json([
            'usuario' => [
                'id' => $user->id,
                'nombres' => $user->nombres,
                'apellidos' => $user->apellidos,
            ],
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function  AllUsers(Request $request)
    {
        $users = User::all();

        return response()->json([
            'message' => 'Datos obtenidos exitosamente',
            'data' => $users,
        ]);
    }

    //Ver datos por id de usuario
    public function show(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        return response()->json([
            'message' => 'Datos obtenidos exitosamente',
            'data' => $user,
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente',
        ]);
    }


      // Verificar cédula
      public function verifyCedula(Request $request)
      {
          $message = "";
          $status = "";
          $request->validate([
              'cedula' => 'required|string',
          ]);
  
          $usuario = User::where('cedula', $request->cedula)->first();
  
          if (!$usuario) {
              $message = "La cédula proporcionada no existe.";
              $status = "0";
          } else {
              $message = "Verificación de cédula exitosa";
              $status = "1";
          }
  
          return response()->json([
              'message' => $message,
              'status' => $status,
          ]);
      }
  
      // Restablecer contraseña por cédula
      public function resetPasswordByCedula(Request $request)
      {
          $message = "";
          $status = "";
          $request->validate([
              'cedula' => 'required|string',
              'new_password' => 'required|string|min:8|confirmed',
          ]);
  
          $usuario = User::where('cedula', $request->cedula)->first();
  
          if (!$usuario) {
              $message = "La cédula proporcionada no existe.";
              $status = "0";
          } else {
              $usuario->password = Hash::make($request->new_password);
              $usuario->save();
              $message = "Contraseña restablecida exitosamente";
              $status = "1";
          }
  
          return response()->json([
              'message' => $message,
              'status' => $status,
          ]);
      }

      /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        $equipo = User::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
    
}
