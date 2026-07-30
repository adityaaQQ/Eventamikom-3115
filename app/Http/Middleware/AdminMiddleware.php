<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN memiliki role admin, superadmin, atau organizer
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'organizer'])) {
            return $next($request); // Lanjutkan request ke halaman admin
        }

        // Jika bukan admin/organizer, tendang ke halaman login
        return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}