<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Pemilih;

class CheckUserOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user adalah superadmin, izinkan akses
        if (auth()->user() && auth()->user()->isSuperAdmin()) {
            return $next($request);
        }

        // Ambil ID pemilih dari route parameter
        $pemilihId = $request->route('pemilih') ?? $request->route('id');
        
        if ($pemilihId) {
            $pemilih = Pemilih::find($pemilihId);
            
            if (!$pemilih) {
                abort(404, 'Data pemilih tidak ditemukan.');
            }

            // Periksa apakah user adalah pemilik data
            if ($pemilih->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses untuk data ini.');
            }
        }

        return $next($request);
    }
}
