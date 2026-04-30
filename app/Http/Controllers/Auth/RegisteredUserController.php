<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Registro Web",
    description: "Endpoints relacionados ao cadastro de usuários via interface web"
)]
class RegisteredUserController extends Controller
{
    #[OA\Get(
        path: "/register",
        summary: "Exibe a página de cadastro de usuário",
        tags: ["Registro Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de cadastro carregada com sucesso"
            )
        ]
    )]
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[OA\Post(
        path: "/register",
        summary: "Realiza o cadastro de um novo usuário via sessão web",
        tags: ["Registro Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Usuário registrado com sucesso e redirecionado"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos ou email já cadastrado"
            )
        ]
    )]
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
