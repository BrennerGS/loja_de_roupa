<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Se não houver usuário, redirecione para login
        if (!$user) {
            return redirect()->route('login');
        }

        // Se for admin, permite tudo
        if ($user->is_admin) {
            return $next($request);
        }

        // Se não especificou permissões, permite acesso
        if (empty($permissions)) {
            return $next($request);
        }

        // Verifica cada permissão
        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        // Se chegou aqui, não tem permissão
        abort(403, 'Você não tem permissão para acessar esta página');
    }
}
