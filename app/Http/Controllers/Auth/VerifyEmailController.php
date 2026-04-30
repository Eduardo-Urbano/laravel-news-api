<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Verificação de Email",
    description: "Endpoints relacionados à confirmação final de verificação de email"
)]
class VerifyEmailController extends Controller
{
    #[OA\Get(
        path: "/verify-email/{id}/{hash}",
        summary: "Verifica o email do usuário através do link enviado",
        tags: ["Verificação de Email"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Email verificado com sucesso e redirecionamento"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            ),
            new OA\Response(
                response: 403,
                description: "Link inválido ou expirado"
            )
        ]
    )]
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
