<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Import facade Auth

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login
        // DAN panggil metode isAdmin() dari user yang sedang login
        // Jika Anda memilih isAdminFromConfig(), ganti Auth::user()->isAdmin() dengan Auth::user()->isAdminFromConfig()
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request); // Lanjutkan request jika admin
        }

        // Jika bukan admin, redirect ke dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk halaman ini.');
        // Atau untuk respons HTTP 403 Forbidden: abort(403, 'Unauthorized access.');
    }
}