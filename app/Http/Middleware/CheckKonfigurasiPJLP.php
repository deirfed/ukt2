<?php

namespace App\Http\Middleware;

use App\Models\FormasiTim;
use App\Models\KonfigurasiCuti;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckKonfigurasiPJLP
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $tahun = Carbon::now()->format('Y');

            // Khusus PJLP
            if ($user->employee_type_id == 3) {
                $missing = [];

                $formasi_tim = FormasiTim::where('periode', $tahun)
                    ->where('anggota_id', $user->id)
                    ->first();

                if (!$formasi_tim) {
                    $missing[] = "Formasi Tim";
                }

                $konfigurasi_cuti = KonfigurasiCuti::where('periode', $tahun)
                    ->where('user_id', $user->id)
                    ->where('jenis_cuti_id', 1) // Cuti Tahunan
                    ->first();

                if (!$konfigurasi_cuti) {
                    $missing[] = "Jatah Cuti";
                }

                if (!empty($missing)) {
                    Auth::logout();
                    return redirect()
                        ->route('login')
                        ->withErrors([
                            'email' => 'Akun anda belum memiliki ' . implode(' dan ', $missing) . ' di tahun ' . $tahun . '. Segera hubungi admin!',
                        ]);
                }
            }
        }

        return $next($request);
    }

}
