<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KepalaSeksi
{
    public function handle(Request $request, Closure $next): Response
    {
        $jabatan_id = auth()->user()->jabatan->id;
        if (($jabatan_id != 2) ){
            return redirect()->back()->withError('Akun anda tidak memiliki otorisasi melakukan aksi ini!');
        }
        return $next($request);
    }
}
