<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            if (Auth::user()->role === 'user') {
                // Hanya blokir halaman login jika sudah login sebagai user
                if ($request->is('user/login')) {
                    return redirect()->route('index');
                }
                return $next($request);
            }

            return redirect('/user/login')->withErrors(['access' => 'You do not have access to this page.']);
        }

        // Izinkan akses ke halaman login user tanpa middleware
        if ($request->is('user/login') || $request->is('user/postLogin')) {
            return $next($request);
        }

        if ($request->is('user/register') || $request->is('user/postLogin')) {
            return $next($request);
        }

        return redirect('/user/login')->withErrors(['access' => 'Please login first to access this page.']);
    }
}
