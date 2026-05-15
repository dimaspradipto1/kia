<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Pastikan relasi role ada dan ambil nama_role (gunakan lowercase untuk pengecekan)
        $userRole = $user->role ? strtolower($user->role->nama_role) : null;

        $allowedRoles = ['admin', 'administrator', 'dinas kesehatan', 'nakes', 'ibu hamil'];

        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
