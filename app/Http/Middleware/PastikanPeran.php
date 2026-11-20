<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PastikanPeran
{
    public function handle(Request $request, Closure $next, string ...$peranDiizinkan): Response
    {
        $pengguna = $request->user();

        if (! $pengguna) {
            return redirect()
                ->route('masuk')
                ->with('galat', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        if (! $pengguna->aktif) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('masuk')
                ->with('galat', 'Akun Anda sedang dinonaktifkan oleh administrator.');
        }

        if (! in_array($pengguna->peran, $peranDiizinkan, true)) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
