<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Recuperação de Senha",
    description: "Endpoints relacionados à solicitação de redefinição de senha"
)]
class PasswordResetLinkController extends Controller
{
    #[OA\Get(
        path: "/forgot-password",
        summary: "Exibe a página para solicitação de redefinição de senha",
        tags: ["Recuperação de Senha"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de recuperação carregada com sucesso"
            )
        ]
    )]
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[OA\Post(
        path: "/forgot-password",
        summary: "Envia link de redefinição de senha para o email informado",
        tags: ["Recuperação de Senha"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Link de redefinição enviado com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Email inválido ou não encontrado"
            )
        ]
    )]
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
