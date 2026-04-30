<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Sessão Web",
    description: "Endpoints relacionados à autenticação via sessão web (Blade/Breeze)"
)]
class AuthenticatedSessionController extends Controller
{
    #[OA\Get(
        path: "/login",
        summary: "Exibe a página de login",
        tags: ["Sessão Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de login carregada com sucesso"
            )
        ]
    )]
    public function create(): View
    {
        return view('auth.login');
    }

    #[OA\Post(
        path: "/login",
        summary: "Realiza login via sessão web",
        tags: ["Sessão Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Login realizado e redirecionamento para dashboard"
            ),
            new OA\Response(
                response: 422,
                description: "Credenciais inválidas"
            )
        ]
    )]
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    #[OA\Post(
        path: "/logout",
        summary: "Realiza logout da sessão web",
        tags: ["Sessão Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Logout realizado com sucesso"
            )
        ]
    )]
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
