<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                // Hanya blokir halaman login jika sudah login sebagai admin
                if ($request->is('admin/login')) {
                    return redirect()->route('admin.dashboard');
                }
                return $next($request);
            }

            return redirect('/')->withErrors(['access' => 'You do not have access to this page.']);
        }

        // Izinkan akses ke halaman login admin tanpa middleware
        if ($request->is('admin/login') || $request->is('admin/postLogin')) {
            return $next($request);
        }

        return redirect('/admin/login')->withErrors(['access' => 'Please login first to access this page.']);
    }
}
