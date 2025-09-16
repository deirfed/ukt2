<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class CheckPassword
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            $default_password = env('DEFAULT_PASSWORD', 'user123');
            if (Hash::check($default_password, $user->password) && !$request->is('user-profile/ubah-password')) {
                return redirect()->route('user.profile.edit.password')->withError('Demi keamanan Anda wajib mengganti password terlebih dahulu, password lama anda <strong><code>' . $default_password . '</code></strong>');
            }
        }

        return $next($request);
    }
}
