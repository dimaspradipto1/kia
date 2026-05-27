<?php

namespace App\Http\Controllers;

use App\Models\LayananIntro;
use App\Models\LayananIntroImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class LayananIntroController extends Controller
{
    public function index()
    {
        $intro = LayananIntro::with(['images', 'defaultImage'])->where('is_active', true)->first();
        return view('pages.layanan_intro.index', compact('intro'));
    }

    public function create()
    {
        return view('pages.layanan_intro.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'badge_text'        => 'required|string|max:100',
            'judul'             => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'fitur'             => 'nullable|array',
            'fitur.*.judul'     => 'required_with:fitur|string|max:150',
            'fitur.*.deskripsi' => 'required_with:fitur|string',
            'is_active'         => 'required|boolean',
            'images'            => 'nullable|array',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'default_index'     => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request, $data) {
            $fitur = [];
            if ($request->has('fitur')) {
                foreach ($request->fitur as $item) {
                    if (!empty(trim($item['judul']))) {
                        $fitur[] = [
                            'judul'     => trim($item['judul']),
                            'deskripsi' => trim($item['deskripsi'] ?? ''),
                        ];
                    }
                }
            }

            $intro = LayananIntro::create([
                'badge_text' => $data['badge_text'],
                'judul'      => $data['judul'],
                'deskripsi'  => $data['deskripsi'] ?? null,
                'fitur'      => $fitur ?: null,
                'is_active'  => $data['is_active'],
            ]);

            if ($request->hasFile('images')) {
                $defaultIndex = (int) $request->input('default_index', 0);
                foreach ($request->file('images') as $i => $file) {
                    $path = $file->store('layanan_intros', 'public');
                    LayananIntroImage::create([
                        'layanan_intro_id' => $intro->id,
                        'path'             => $path,
                        'keterangan'       => $request->keterangan[$i] ?? null,
                        'is_default'       => ($i === $defaultIndex),
                        'urutan'           => $i,
                    ]);
                }
            }
        });

        Alert::success('Berhasil', 'Konten intro layanan berhasil ditambahkan.');
        return redirect()->route('layanan-intro.index');
    }

    public function show(LayananIntro $layananIntro)
    {
        $layananIntro->load(['images', 'defaultImage']);
        return view('pages.layanan_intro.show', compact('layananIntro'));
    }

    public function edit(LayananIntro $layananIntro)
    {
        $layananIntro->load('images');
        return view('pages.layanan_intro.edit', compact('layananIntro'));
    }

    public function update(Request $request, LayananIntro $layananIntro)
    {
        $data = $request->validate([
            'badge_text'        => 'required|string|max:100',
            'judul'             => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'fitur'             => 'nullable|array',
            'fitur.*.judul'     => 'required_with:fitur|string|max:150',
            'fitur.*.deskripsi' => 'required_with:fitur|string',
            'is_active'         => 'required|boolean',
            'images'            => 'nullable|array',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'default_image_id'  => 'nullable|integer',
            'delete_images'     => 'nullable|array',
            'delete_images.*'   => 'integer',
        ]);

        DB::transaction(function () use ($request, $data, $layananIntro) {
            $fitur = [];
            if ($request->has('fitur')) {
                foreach ($request->fitur as $item) {
                    if (!empty(trim($item['judul']))) {
                        $fitur[] = [
                            'judul'     => trim($item['judul']),
                            'deskripsi' => trim($item['deskripsi'] ?? ''),
                        ];
                    }
                }
            }

            $layananIntro->update([
                'badge_text' => $data['badge_text'],
                'judul'      => $data['judul'],
                'deskripsi'  => $data['deskripsi'] ?? null,
                'fitur'      => $fitur ?: null,
                'is_active'  => $data['is_active'],
            ]);

            // Hapus gambar yang dicentang
            if ($request->filled('delete_images')) {
                $toDelete = LayananIntroImage::where('layanan_intro_id', $layananIntro->id)
                    ->whereIn('id', $request->delete_images)
                    ->get();
                foreach ($toDelete as $img) {
                    Storage::disk('public')->delete($img->path);
                    $img->delete();
                }
            }

            // Atur ulang default
            if ($request->filled('default_image_id')) {
                LayananIntroImage::where('layanan_intro_id', $layananIntro->id)
                    ->update(['is_default' => false]);
                LayananIntroImage::where('id', $request->default_image_id)
                    ->where('layanan_intro_id', $layananIntro->id)
                    ->update(['is_default' => true]);
            }

            // Upload gambar baru
            if ($request->hasFile('images')) {
                $existingCount = $layananIntro->images()->count();
                $newDefaultIndex = (int) $request->input('new_default_index', -1);

                $hasActiveDefault = LayananIntroImage::where('layanan_intro_id', $layananIntro->id)
                    ->where('is_default', true)->exists();

                foreach ($request->file('images') as $i => $file) {
                    $path = $file->store('layanan_intros', 'public');
                    $isDefault = false;

                    if ($newDefaultIndex === $i) {
                        LayananIntroImage::where('layanan_intro_id', $layananIntro->id)->update(['is_default' => false]);
                        $isDefault = true;
                    } elseif (!$hasActiveDefault && $i === 0) {
                        $isDefault = true;
                    }

                    LayananIntroImage::create([
                        'layanan_intro_id' => $layananIntro->id,
                        'path'             => $path,
                        'keterangan'       => $request->new_keterangan[$i] ?? null,
                        'is_default'       => $isDefault,
                        'urutan'           => $existingCount + $i,
                    ]);
                }
            }
        });

        Alert::success('Berhasil', 'Konten intro layanan berhasil diperbarui.');
        return redirect()->route('layanan-intro.index');
    }

    public function destroy(LayananIntro $layananIntro)
    {
        foreach ($layananIntro->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        $layananIntro->delete();

        Alert::success('Berhasil', 'Konten intro layanan berhasil dihapus.');
        return redirect()->route('layanan-intro.index');
    }

    public function destroyImage(Request $request, LayananIntroImage $layananIntroImage)
    {
        Storage::disk('public')->delete($layananIntroImage->path);
        $layananIntroImage->delete();

        Alert::success('Berhasil', 'Gambar berhasil dihapus.');
        return back();
    }

    public function setDefaultImage(Request $request, LayananIntroImage $layananIntroImage)
    {
        LayananIntroImage::where('layanan_intro_id', $layananIntroImage->layanan_intro_id)
            ->update(['is_default' => false]);
        $layananIntroImage->update(['is_default' => true]);

        Alert::success('Berhasil', 'Gambar default berhasil diperbarui.');
        return back();
    }
}
