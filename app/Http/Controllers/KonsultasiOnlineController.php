<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiOnline;
use App\Models\FasilitasKesehatan;
use App\DataTables\KonsultasiOnlineDataTable;
use App\Http\Requests\KonsultasiOnlineRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KonsultasiOnlineController extends Controller
{
    /**
     * Tampilkan formulir identitas untuk akses publik (tanpa login manual)
     */
    public function guestForm()
    {
        // Jika sudah login, arahkan ke telemedisin
        if (auth()->check()) {
            return redirect()->route('konsultasi-online.index');
        }

        $faskes = FasilitasKesehatan::all();
        return view('pages.konsultasi_online.guest', compact('faskes'));
    }

    /**
     * Proses identitas publik, auto-create/login user, lalu redirect ke chat
     */
    public function guestLogin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'faskes_id' => 'required|exists:fasilitas_kesehatans,id'
        ]);

        $email = $request->nik . '@telemedisin.kia';

        $user = \App\Models\User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $request->nama,
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
                'roles_id' => 4, // Ibu Hamil
                'is_active' => true
            ]
        );

        if ($user->wasRecentlyCreated || !$user->profilIbu) {
            \App\Models\ProfilIbu::create([
                'user_id' => $user->id,
                'fasilitas_kesehatan_id' => $request->faskes_id,
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama,
                'tempat_lahir' => 'Sistem Medis',
                'tanggal_lahir' => '2000-01-01',
            ]);
        } else {
            if($user->profilIbu) {
               $user->profilIbu->update(['fasilitas_kesehatan_id' => $request->faskes_id]);
            }
        }

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('konsultasi-online.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $chatListQuery = KonsultasiOnline::with(['user.profilIbu', 'fasilitasKesehatan'])->orderBy('updated_at', 'desc');
        
        // Filter consultations based on roles
        if ($user->role->nama_role === 'ibu hamil') {
            $hasChats = KonsultasiOnline::where('user_id', $user->id)->exists();
            if (!$hasChats) {
                $faskesId = null;
                if ($user->profilIbu) {
                    $faskesId = $user->profilIbu->fasilitas_kesehatan_id;
                }
                if (!$faskesId) {
                    $faskesId = FasilitasKesehatan::first()->id ?? null;
                }
                
                if ($faskesId) {
                    $session = KonsultasiOnline::create([
                        'user_id'                => $user->id,
                        'fasilitas_kesehatan_id' => $faskesId,
                        'topik'                  => 'Konsultasi Medis Online',
                        'pesan'                  => 'Sesi konsultasi diaktifkan secara otomatis.',
                        'status'                 => 'pending'
                    ]);
                    
                    \App\Models\KonsultasiOnlineMessage::create([
                        'konsultasi_online_id' => $session->id,
                        'sender_id'            => $user->id,
                        'message'              => 'Halo, saya ingin berkonsultasi mengenai kesehatan kehamilan saya.',
                    ]);
                }
            }
            $chatListQuery->where('user_id', $user->id);
        } elseif (in_array(strtolower($user->role->nama_role ?? ''), ['nakes', 'kader posyandu', 'kader']) && $user->fasilitas_kesehatan_id) {
            $chatListQuery->where('fasilitas_kesehatan_id', $user->fasilitas_kesehatan_id);
        }
        
        $otherConsultations = $chatListQuery->get();
        
        // Determine the active chat session
        $activeChatId = $request->query('chat_id');
        $konsultasiOnline = null;
        
        if ($activeChatId) {
            $konsultasiOnline = KonsultasiOnline::with(['user.profilIbu', 'fasilitasKesehatan', 'messages.sender'])->find($activeChatId);
        } elseif ($otherConsultations->isNotEmpty()) {
            $konsultasiOnline = $otherConsultations->first();
            $konsultasiOnline->load('messages.sender');
        }

        if ($konsultasiOnline) {
            // Mark all incoming messages in this chat as read
            $konsultasiOnline->messages()
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
        
        // Fetch health facilities and user's default faskes for the integrated new chat form
        $faskesList = FasilitasKesehatan::all();
        $userFaskesId = null;
        if ($user->profilIbu) {
            $userFaskesId = $user->profilIbu->fasilitas_kesehatan_id;
        }
        
        return view('pages.konsultasi_online.index', compact('otherConsultations', 'konsultasiOnline', 'faskesList', 'userFaskesId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userRole = auth()->user()->role->nama_role;
        if ($userRole !== 'ibu hamil' && $userRole !== 'administrator') {
            abort(403, 'Hanya pasien (Ibu Hamil) yang dapat mengajukan keluhan/konsultasi baru.');
        }

        $faskesList = FasilitasKesehatan::all();
        
        // Try to pre-select user's faskes from profile if it exists
        $userFaskesId = null;
        if (auth()->user()->profilIbu) {
            $userFaskesId = auth()->user()->profilIbu->fasilitas_kesehatan_id;
        }

        return view('pages.konsultasi_online.create', compact('faskesList', 'userFaskesId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KonsultasiOnlineRequest $request)
    {
        $userRole = auth()->user()->role->nama_role;
        if ($userRole !== 'ibu hamil' && $userRole !== 'administrator') {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $session = KonsultasiOnline::create([
            'user_id'                => auth()->id(),
            'fasilitas_kesehatan_id' => $request->fasilitas_kesehatan_id,
            'topik'                  => $request->topik,
            'pesan'                  => $request->pesan,
            'status'                 => 'pending'
        ]);

        // Insert first message into the chat messages log
        \App\Models\KonsultasiOnlineMessage::create([
            'konsultasi_online_id' => $session->id,
            'sender_id'            => auth()->id(),
            'message'              => $request->pesan,
        ]);

        return redirect()->route('konsultasi-online.index', ['chat_id' => $session->id])
            ->with('success', 'Pertanyaan konsultasi online Anda berhasil dikirim ke Tenaga Kesehatan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KonsultasiOnline $konsultasiOnline)
    {
        // Smoothly redirect to the index page with the target chat session activated
        return redirect()->route('konsultasi-online.index', ['chat_id' => $konsultasiOnline->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KonsultasiOnline $konsultasiOnline)
    {
        $user = auth()->user();
        $userRole = $user->role->nama_role;

        // Bidan/Nakes/Kader/Admin editing is actually writing the medical response
        if (in_array(strtolower($userRole), ['nakes', 'administrator', 'kader posyandu', 'kader'])) {
            $konsultasiOnline->load(['user.profilIbu', 'fasilitasKesehatan']);
            return view('pages.konsultasi_online.respond', compact('konsultasiOnline'));
        }

        // Patient editing is changing their question before it is answered
        if ($userRole === 'ibu hamil') {
            if ($konsultasiOnline->user_id !== $user->id) {
                abort(403, 'Akses ditolak.');
            }
            if ($konsultasiOnline->status !== 'pending') {
                return redirect()->route('konsultasi-online.index')
                    ->with('error', 'Konsultasi yang sudah dijawab tidak dapat diubah lagi.');
            }

            $faskesList = FasilitasKesehatan::all();
            return view('pages.konsultasi_online.edit', compact('konsultasiOnline', 'faskesList'));
        }

        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KonsultasiOnlineRequest $request, KonsultasiOnline $konsultasiOnline)
    {
        $user = auth()->user();
        $userRole = $user->role->nama_role;

        // Bidan/Nakes/Kader responding to the query
        if (in_array(strtolower($userRole), ['nakes', 'administrator', 'kader posyandu', 'kader'])) {
            $konsultasiOnline->update([
                'respons'        => $request->respons,
                'direspons_oleh' => $user->name,
                'status'         => $request->status,
                'direspons_pada' => now()
            ]);

            // Save response message to conversation log
            \App\Models\KonsultasiOnlineMessage::create([
                'konsultasi_online_id' => $konsultasiOnline->id,
                'sender_id'            => $user->id,
                'message'              => $request->respons,
            ]);

            return redirect()->route('konsultasi-online.index', ['chat_id' => $konsultasiOnline->id])
                ->with('success', 'Tanggapan/Saran medis berhasil dikirim.');
        }

        // Patient updating their own question
        if ($userRole === 'ibu hamil') {
            if ($konsultasiOnline->user_id !== $user->id) {
                abort(403, 'Akses ditolak.');
            }
            if ($konsultasiOnline->status !== 'pending') {
                return redirect()->route('konsultasi-online.index')
                    ->with('error', 'Konsultasi yang sudah dijawab tidak dapat diubah lagi.');
            }

            $konsultasiOnline->update([
                'fasilitas_kesehatan_id' => $request->fasilitas_kesehatan_id,
                'topik'                  => $request->topik,
                'pesan'                  => $request->pesan,
            ]);

            // Create a new chat message so the updated patient message is delivered as a new incoming item.
            \App\Models\KonsultasiOnlineMessage::create([
                'konsultasi_online_id' => $konsultasiOnline->id,
                'sender_id'            => $user->id,
                'message'              => $request->pesan,
            ]);

            return redirect()->route('konsultasi-online.index', ['chat_id' => $konsultasiOnline->id])
                ->with('success', 'Pertanyaan konsultasi online Anda berhasil diperbarui.');
        }

        abort(403);
    }

    /**
     * Post a reply back-and-forth dynamically inside the WhatsApp thread.
     */
    public function reply(Request $request, KonsultasiOnline $konsultasiOnline)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = auth()->user();
        $userRole = $user->role->nama_role;

        // 1. Create the new message in the chat log
        \App\Models\KonsultasiOnlineMessage::create([
            'konsultasi_online_id' => $konsultasiOnline->id,
            'sender_id'            => $user->id,
            'message'              => $request->message,
        ]);

        // 2. Automatically update compatibility cache on main table and set status
        if (in_array(strtolower($userRole), ['nakes', 'administrator', 'kader posyandu', 'kader'])) {
            $konsultasiOnline->update([
                'respons'        => $request->message,
                'direspons_oleh' => $user->name,
                'status'         => 'accepted',
                'direspons_pada' => now()
            ]);
        } else {
            $konsultasiOnline->update([
                'pesan'  => $request->message,
                'status' => 'pending' // Re-mark as pending to alert Nakes of a new message
            ]);
        }

        return redirect()->route('konsultasi-online.index', ['chat_id' => $konsultasiOnline->id])
            ->with('success', 'Pesan berhasil dikirim.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KonsultasiOnline $konsultasiOnline)
    {
        $user = auth()->user();
        $userRole = $user->role->nama_role;

        // Patient can only delete if pending
        if ($userRole === 'ibu hamil') {
            if ($konsultasiOnline->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak.'
                ], 403);
            }
            if ($konsultasiOnline->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pertanyaan yang sudah dijawab oleh Tenaga Kesehatan tidak boleh dihapus.'
                ], 422);
            }
        }

        $konsultasiOnline->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data konsultasi online berhasil dihapus dari sistem.'
        ]);
    }

    public function checkUpdates(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        $query = KonsultasiOnline::with(['messages' => function ($q) {
            $q->orderBy('id', 'desc');
        }, 'user', 'fasilitasKesehatan']);

        if (strtolower($user->role->nama_role ?? '') === 'ibu hamil') {
            $query->where('user_id', $user->id);
        } elseif (in_array(strtolower($user->role->nama_role ?? ''), ['nakes', 'kader posyandu', 'kader']) && $user->fasilitas_kesehatan_id) {
            $query->where('fasilitas_kesehatan_id', $user->fasilitas_kesehatan_id);
        }

        $sessions = $query->get();
        $updates = [];

        foreach ($sessions as $session) {
            $lastMsg = $session->messages->first();
            if ($lastMsg) {
                $updates[] = [
                    'session_id' => $session->id,
                    'last_message_id' => $lastMsg->id,
                    'sender_name' => $lastMsg->sender->name ?? 'User',
                    'sender_id' => $lastMsg->sender_id,
                    'message' => Str::limit($lastMsg->message, 50),
                    'time' => $lastMsg->created_at ? $lastMsg->created_at->format('H:i') : '',
                    'status' => $session->status,
                    'partner_name' => $user->role->nama_role === 'ibu hamil'
                        ? ($session->fasilitasKesehatan->nama_faskes ?? 'Klinik')
                        : ($session->user->name ?? 'Pasien')
                ];
            }
        }

        return response()->json([
            'success' => true,
            'updates' => $updates,
            'user_id' => $user->id
        ]);
    }

    public function fetchMessages(Request $request, KonsultasiOnline $konsultasiOnline)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        if ($user->role->nama_role === 'ibu hamil' && $konsultasiOnline->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        if (in_array(strtolower($user->role->nama_role ?? ''), ['nakes', 'kader posyandu', 'kader']) && $user->fasilitas_kesehatan_id && $konsultasiOnline->fasilitas_kesehatan_id !== $user->fasilitas_kesehatan_id) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $sinceId = $request->query('since_id');

        $query = $konsultasiOnline->messages()->with('sender')->orderBy('id', 'asc');
        if ($sinceId) {
            $query->where('id', '>', $sinceId);
        }

        $messages = $query->get()->map(function ($msg) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_id' => $msg->sender_id,
                'sender_name' => $msg->sender->name ?? 'Pengguna',
                'sender_role' => $msg->sender->role->nama_role ?? '',
                'created_at' => $msg->created_at ? $msg->created_at->translatedFormat('d F Y H:i') : '',
                'is_me' => $msg->sender_id === auth()->id(),
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'latest_message_id' => optional($messages->last())['id'] ?? (int) $sinceId,
        ]);
    }
}
