<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Verificação de Email",
    description: "Endpoints relacionados à verificação e confirmação de email do usuário"
)]
class EmailVerificationPromptController extends Controller
{
    #[OA\Get(
        path: "/verify-email",
        summary: "Exibe a página de verificação de email ou redireciona se já estiver verificado",
        tags: ["Verificação de Email"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de verificação exibida com sucesso"
            ),
            new OA\Response(
                response: 302,
                description: "Usuário já verificado e redirecionado"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : view('auth.verify-email');
    }
}
