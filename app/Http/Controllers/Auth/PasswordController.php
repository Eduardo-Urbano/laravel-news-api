<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Senha",
    description: "Endpoints relacionados à atualização de senha do usuário autenticado"
)]
class PasswordController extends Controller
{
    #[OA\Put(
        path: "/password",
        summary: "Atualiza a senha do usuário autenticado",
        tags: ["Senha"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Senha atualizada com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos ou senha atual incorreta"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
