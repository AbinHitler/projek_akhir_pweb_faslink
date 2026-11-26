<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Pastikan hanya admin yang sudah login yang bisa mengakses halaman admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->guest(route('login'))
                ->with('error', 'Silakan login sebagai admin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
