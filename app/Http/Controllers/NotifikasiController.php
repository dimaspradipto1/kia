<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return view('pages.notifikasi.index', compact('notifikasi'));
    }

    public function markRead(string $id)
    {
        $notif = auth()->user()->notifications()->findOrFail($id);
        $notif->markAsRead();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $link = $notif->data['link'] ?? route('notifikasi.index');
        return redirect($link);
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    public function unreadCount()
    {
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count(),
            'items' => auth()->user()->unreadNotifications()
                ->latest()
                ->take(5)
                ->get()
                ->map(fn($n) => [
                    'id'    => $n->id,
                    'judul' => $n->data['judul'],
                    'pesan' => $n->data['pesan'],
                    'icon'  => $n->data['icon'] ?? 'bi-bell',
                    'tipe'  => $n->data['tipe'],
                    'link'  => $n->data['link'],
                    'waktu' => $n->created_at->diffForHumans(),
                ]),
        ]);
    }

    public function destroy(string $id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifikasi dihapus.');
    }
}
