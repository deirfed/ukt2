<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!$request->user() || !$request->user()->hasRole(...$roles)) {
            // abort(403, 'Unauthorized action.');
            return redirect()->route('dashboard.index')->withError('Anda tidak memiliki otorisasi melakukan aksi ini!.');
        }

        return $next($request);
    }
}
