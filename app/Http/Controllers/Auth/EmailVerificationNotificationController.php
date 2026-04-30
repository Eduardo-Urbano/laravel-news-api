<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Verificação de Email",
    description: "Endpoints relacionados ao envio de notificações de verificação de email"
)]
class EmailVerificationNotificationController extends Controller
{
    #[OA\Post(
        path: "/email/verification-notification",
        summary: "Envia ou reenvia o link de verificação de email para o usuário autenticado",
        tags: ["Verificação de Email"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Link de verificação enviado ou redirecionamento caso email já esteja verificado"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
