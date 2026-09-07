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

        // Pastikan relasi role ada dan ambil nama_role (gunakan lowercase dan trim untuk pengecekan)
        $userRole = $user->role ? trim(strtolower($user->role->nama_role)) : null;

        $allowedRoles = ['admin', 'administrator', 'dinas kesehatan', 'nakes', 'ibu hamil', 'pengguna', 'kader posyandu', 'kader'];

        if (in_array($userRole, $allowedRoles)) {
            // Jika role adalah 'ibu hamil', batasi akses ke pemeriksaan medis dan faskes agar hanya bisa melihat (read-only)
            // Namun izinkan ibu hamil untuk mengisi data ibu, suami, anak, pembiayaan, dan dokumen
            if ($userRole === 'ibu hamil') {
                $routeName = $request->route() ? $request->route()->getName() : null;
                if ($routeName) {
                    $restrictedResources = [
                        'buku-kia',
                        'kunjungan-anc',
                        'bayi-baru-lahir',
                        'imunisasi-anak',
                        'tumbuh-kembang',
                        'perkembangan-sidtk',
                        'mpasi',
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
                                    'message' => 'Halaman pemeriksaan medis hanya dapat diisi atau diperbarui oleh Tenaga Kesehatan / Kader.'
                                ], 403);
                            }
                            return redirect()->route('dashboard')->with('error', 'Halaman pemeriksaan medis hanya dapat diisi atau diperbarui oleh Tenaga Kesehatan / Kader.');
                        }
                    }
                }
            }

            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
