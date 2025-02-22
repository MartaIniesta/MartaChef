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
     * Registra un nuevo usuario en el sistema.
     *
     * @bodyParam name string El nombre del usuario. Example: Pepe
     * @bodyParam email string El correo electrónico del usuario. Example: pepe@example.com
     * @bodyParam password string La contraseña del usuario (mínimo 8 caracteres). Example: 12345678
     * @bodyParam password_confirmation string Confirmar la contraseña del usuario. Example: 12345678
     *
     * @response 201 {
     *   "message": "User registered successfully.",
     *   "token": "your_generated_token_here"
     * }
     *
     * @response 422 {
     *   "errors": {
     *     "email": ["The email has already been taken."]
     *   }
     * }
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
            'message' => 'User registered successfully.',
            'token'   => $token,
        ]);
    }

    /**
     * @group Autenticación
     *
     * Inicia sesión y devuelve un token de autenticación para el usuario.
     *
     * @bodyParam email string El correo electrónico del usuario. Example: pepe@example.com
     * @bodyParam password string La contraseña del usuario. Example: 12345678
     *
     * @response 200 {
     *   "access_token": "your_generated_token_here",
     *   "token_type": "Bearer"
     * }
     *
     * @response 401 {
     *   "message": "Credenciales incorrectas"
     * }
     */
    public function login(Request $request)
    {
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
