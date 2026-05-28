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

        $allowedRoles = ['admin', 'administrator', 'dinas kesehatan', 'nakes', 'ibu hamil', 'pengguna'];

        if (in_array($userRole, $allowedRoles)) {
            // Jika role adalah 'ibu hamil', batasi akses ke menu-menu tertentu agar hanya bisa melihat (read-only)
            if ($userRole === 'ibu hamil') {
                $routeName = $request->route() ? $request->route()->getName() : null;
                if ($routeName) {
                    $restrictedResources = [
                        'buku-kia',
                        'kunjungan-anc',
                        'profil-ibu',
                        'profil-suami',
                        'profil-anak',
                        'bayi-baru-lahir',
                        'imunisasi-anak',
                        'tumbuh-kembang',
                        'perkembangan-sidtk',
                        'mpasi',
                        'pembiayaan',
                        'pemantauan-nifas',
                        'kb-pasca-salin',
                        'hasil-lab-ibu',
                        'pencatatan-ttd',
                        'persalinan',
                        'fasilitas-kesehatan'
                    ];

                    $parts = explode('.', $routeName);
                    $resourcePrefix = $parts[0];

                    if (in_array($resourcePrefix, $restrictedResources)) {
                        $action = end($parts);
                        $allowedActions = ['index', 'show'];

                        if (!in_array($action, $allowedActions)) {
                            if ($request->ajax() || $request->wantsJson()) {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Anda tidak memiliki akses untuk menambah, mengedit, atau menghapus data ini.'
                                ], 403);
                            }
                            return redirect()->route('dashboard')->with('error', 'Anda hanya memiliki akses untuk melihat data pada menu ini.');
                        }
                    }
                }
            }

            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
