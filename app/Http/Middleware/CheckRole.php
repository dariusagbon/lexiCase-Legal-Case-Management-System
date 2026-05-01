<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $roles = ''): RedirectResponse|Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowedRoles = array_filter(array_map('trim', explode(',', $roles)));

        if (! in_array($request->user()->role, $allowedRoles, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
