<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Panitia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Mengecek apakah pengguna sudah login dan rolenya adalah panitia
        if (Auth::check() && Auth::user()->role_id != 3) {
          return redirect()->to('login');
        }
        return $next($request);
        // Jika bukan panitia, redirect atau tolak akses
        return redirect('/'); // Misal redirect ke halaman utama atau error page
    }
}
