<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Confirmação de Senha",
    description: "Endpoints relacionados à confirmação de senha para ações sensíveis na sessão web"
)]
class ConfirmablePasswordController extends Controller
{
    #[OA\Get(
        path: "/confirm-password",
        summary: "Exibe a página de confirmação de senha",
        tags: ["Confirmação de Senha"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de confirmação carregada com sucesso"
            )
        ]
    )]
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    #[OA\Post(
        path: "/confirm-password",
        summary: "Confirma a senha do usuário autenticado",
        tags: ["Confirmação de Senha"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Senha confirmada com sucesso e redirecionamento"
            ),
            new OA\Response(
                response: 422,
                description: "Senha inválida"
            )
        ]
    )]
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
