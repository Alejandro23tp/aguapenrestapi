<?php

namespace App\Rest\Controllers;

use App\Models\User;
use App\Models\Usuarios;
use App\Rest\Controller as RestController;
use App\Rest\Resources\UsuariosResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class UsuariosController extends RestController
{
    /**
     * The resource the controller corresponds to.
     *
     * @var class-string<\Lomkit\Rest\Http\Resource>
     */
    public static $resource = UsuariosResource::class;


    // Obtener todos los productos
    public function  AllUsers(Request $request)
    {
        $users = User::all();

        return response()->json([
            'message' => 'Datos obtenidos exitosamente',
            'data' => $users,
        ]);
    }

    public function verifyToken(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token no proporcionado.'], 401);
        }

        $token = explode('|', $token, 2)[1] ?? null;

        if (!$token) {
            return response()->json(['message' => 'Token no válido.'], 401);
        }

        $tokenModel = PersonalAccessToken::findToken($token);

        if (!$tokenModel || !$tokenModel->tokenable) {
            return response()->json(['message' => 'Token no válido.'], 401);
        }

        if ($tokenModel->expires_at && $tokenModel->expires_at < now()) {
            return response()->json(['message' => 'Token expirado.'], 401);
        }

        return response()->json(['message' => 'Token válido.']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = Usuarios::where('usuario', $request->usuario)->first();

        if (!$usuario) {
            return response()->json([
                'message' => 'El usuario no existe.',
            ], 404);
        }

        if (!Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'message' => 'Contraseña incorrecta.',
            ], 401);
        }

        // Generar el token de API con lógica personalizada para expiración
        $expiration = now()->addMinutes(config('sanctum.expiration'));

        $tokenResult = $usuario->createToken('auth_token', ['*'], $expiration);
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'message' => 'Login exitoso',
            'usuario' => [
                'id' => $usuario->id,
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
            ],
            'token' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'expiration' => $expiration->toDateTimeString(),
            ]
        ]);
    }

    //Ver datos por id de usuario
    public function show(Request $request)
    {


        $usuario = Usuarios::where('id', $request->id)->first();

        if (!$usuario) {
            throw ValidationException::withMessages([
                'id' => ['El usuario no existe.'],
            ]);
        }

        return response()->json([
            'message' => 'Datos exitoso',
            'usuario' =>  $usuario,
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

        $usuario = Usuarios::where('cedula', $request->cedula)->first();

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

        $usuario = Usuarios::where('cedula', $request->cedula)->first();

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
        $equipo = Usuarios::findOrFail($id);
        $equipo->delete();

        return $this->respondNoContent();
    }
    
}
