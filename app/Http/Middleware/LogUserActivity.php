<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AccessLog; // Pastikan model ini sudah ada
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        $userId = Auth::check() ? Auth::id() : null;
        $url = $request->fullUrl();
        $ipAddress = $request->ip();
        $accessedAt = Carbon::now('Asia/Jakarta');

        DB::table('access_logs')->insert([
            'user_id' => $userId,
            'url' => $url,
            'ip_address' => $ipAddress,
            'accessed_at' => $accessedAt,
        ]);

        return $next($request);
    }
}

