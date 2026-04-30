<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Autenticação",
    description: "Endpoints relacionados ao registro, login e logout de usuários"
)]
class AuthController extends Controller
{
    #[OA\Post(
        path: "/api/register",
        summary: "Cadastra um novo usuário",
        tags: ["Autenticação"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Usuário cadastrado com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            )
        ]
    )]
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    #[OA\Post(
        path: "/api/login",
        summary: "Realiza login do usuário e retorna token de autenticação",
        tags: ["Autenticação"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Login realizado com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Credenciais inválidas"
            )
        ]
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    #[OA\Post(
        path: "/api/logout",
        summary: "Realiza logout do usuário autenticado",
        tags: ["Autenticação"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Logout realizado com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}
