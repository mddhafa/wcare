<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleKorban
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role_id != 3) {
            abort(403, 'Hanya korban yang dapat membuat laporan.');
        }

        return $next($request);
    }
}