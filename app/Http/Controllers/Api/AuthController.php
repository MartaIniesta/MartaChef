<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @group Autenticación
     *
     * Registra un nuevo usuario y devuelve un token de autentificación para el usuario.
     *
     * @bodyParam name string required Nombre del usuario. Example: Pepe
     * @bodyParam email string required Correo electrónico. Example: pepe@example.com
     * @bodyParam password string required Contraseña del usuario (mínimo 8 caracteres). Example: 12345678
     * @bodyParam password_confirmation string required Confirmar la contraseña del usuario. Example: 12345678
     *
     * @response 201 {
     *   "message": "Usuario registrado correctamente.",
     *   "token": "your_generated_token_here"
     * }
     *
     * @response 422 {
     *     "message": "Se ha producido un error de validación.",
     *     "errors": {
     *       "name": ["El campo nombre es obligatorio."],
     *       "email": ["El correo ya está registrado."],
     *       "password": ["El campo contraseña es obligatorio.", "La confirmación no coincide."]
     *     }
     *  }
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token_name')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado correctamente.',
            'token'   => $token,
        ]);
    }

    /**
     * @group Autenticación
     *
     * Inicia sesión y devuelve un token de autenticación para el usuario.
     *
     * @bodyParam email string required Correo electrónico. Example: pepe@example.com
     * @bodyParam password string required Contraseña del usuario. Example: 12345678
     *
     * @response 200 {
     *   "access_token": "your_generated_token_here",
     *   "token_type": "Bearer"
     * }
     *
     * @response 401 {
     *   "message": "Credenciales incorrectas"
     * }
     *
     * @response 422 {
     *    "message": "Se ha producido un error de validación.",
     *    "errors": {
     *      "email": ["El campo email es obligatorio."],
     *      "password": ["El campo password es obligatorio."]
     *    }
     *  }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $token = $user->createToken('token_name')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
}
