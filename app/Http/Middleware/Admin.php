<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
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
        // Memastikan user telah login dan memiliki role_id 1 sebagai admin
        if (Auth::check() && Auth::user()->role_id == 1 || auth()->user()->role_id == 3) {
            return $next($request);
        }

        // Jika bukan admin, redirect ke halaman login
        return redirect()->to('login')->with('error', 'Akses ditolak. Anda bukan admin.');
    }
}
