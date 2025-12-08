<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = Auth::user();
        $user->load('role');
        
        $userRole = $user->role?->name ?? null;

        if (!in_array($userRole, $roles)) {
            return $this->redirectToDashboard($userRole);
        }

        return $next($request);

        // if (Auth::user()->role == $role) {
        //     return $next($request);
        // } else {
        //     return redirect('/')->withErrors(['error' => 'You do not have the correct role to access this page.']);
        // }

        // return redirect('/login');
    }

    private function redirectToDashboard(?string $role): Response
    {
        $message = "Anda tidak memiliki akses ke halaman tersebut";

        switch($role) {
            case 'admin':
                return redirect('/admin/dashboard')->with('error', $message);
            case 'psikolog':
                return redirect('/psikolog/dashboard')->with('error', $message);
            case 'korban':
                return redirect('/dashboard')->with('error', $message);
            default:
                return redirect('/login')->with('error', 'Role tidak valid');
        }
    }
}
