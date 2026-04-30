<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Redefinição de Senha",
    description: "Endpoints relacionados à criação e redefinição de senha do usuário"
)]
class NewPasswordController extends Controller
{
    #[OA\Get(
        path: "/reset-password/{token}",
        summary: "Exibe a página de redefinição de senha",
        tags: ["Redefinição de Senha"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de redefinição carregada com sucesso"
            )
        ]
    )]
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[OA\Post(
        path: "/reset-password",
        summary: "Redefine a senha do usuário com token válido",
        tags: ["Redefinição de Senha"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Senha redefinida com sucesso e redirecionamento para login"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos ou token expirado"
            )
        ]
    )]
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
