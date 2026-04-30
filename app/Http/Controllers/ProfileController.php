<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Perfil",
    description: "Endpoints relacionados ao gerenciamento de perfil do usuário autenticado"
)]
class ProfileController extends Controller
{
    #[OA\Get(
        path: "/profile",
        summary: "Exibe a página de edição de perfil",
        tags: ["Perfil"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de perfil carregada com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    #[OA\Patch(
        path: "/profile",
        summary: "Atualiza os dados do perfil do usuário autenticado",
        tags: ["Perfil"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Perfil atualizado com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('status', 'profile-updated');
    }

    #[OA\Delete(
        path: "/profile",
        summary: "Deleta a conta do usuário autenticado",
        tags: ["Perfil"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Conta deletada com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('status', 'Conta deletada com sucesso.');
    }
}
