<?php

namespace App\Http\Controllers;

use App\DataTables\AboutDataTable;
use App\Models\About;
use App\Models\AboutImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AboutController extends Controller
{
    public function index(AboutDataTable $dataTable)
    {
        return $dataTable->render('pages.about.index');
    }

    public function create()
    {
        return view('pages.about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'sub_judul'        => 'nullable|string|max:255',
            'deskripsi_pendek' => 'nullable|string',
            'deskripsi_panjang'=> 'nullable|string',
            'fitur'            => 'nullable|string',
            'tahun_mengabdi'   => 'nullable|integer|min:1|max:9999',
            'is_active'        => 'required|boolean',
            'images'           => 'nullable|array',
            'images.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'default_index'    => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request) {
            // Simpan fitur sebagai JSON array (satu baris = satu fitur)
            $fiturArray = null;
            if ($request->filled('fitur')) {
                $fiturArray = array_values(array_filter(
                    array_map('trim', explode("\n", $request->fitur))
                ));
            }

            $about = About::create([
                'judul'             => $request->judul,
                'sub_judul'         => $request->sub_judul,
                'deskripsi_pendek'  => $request->deskripsi_pendek,
                'deskripsi_panjang' => $request->deskripsi_panjang,
                'fitur'             => $fiturArray,
                'tahun_mengabdi'    => $request->tahun_mengabdi,
                'is_active'         => $request->is_active,
            ]);

            // Simpan gambar
            if ($request->hasFile('images')) {
                $defaultIndex = (int) $request->input('default_index', 0);
                foreach ($request->file('images') as $i => $file) {
                    $path = $file->store('abouts', 'public');
                    AboutImage::create([
                        'about_id'   => $about->id,
                        'path'       => $path,
                        'keterangan' => $request->keterangan[$i] ?? null,
                        'is_default' => ($i === $defaultIndex),
                        'urutan'     => $i,
                    ]);
                }
            }
        });

        Alert::success('Berhasil', 'Data about berhasil ditambahkan.');
        return redirect()->route('abouts.index');
    }

    public function show(About $about)
    {
        $about->load(['images', 'defaultImage']);
        return view('pages.about.show', compact('about'));
    }

    public function edit(About $about)
    {
        $about->load('images');
        return view('pages.about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'sub_judul'        => 'nullable|string|max:255',
            'deskripsi_pendek' => 'nullable|string',
            'deskripsi_panjang'=> 'nullable|string',
            'fitur'            => 'nullable|string',
            'tahun_mengabdi'   => 'nullable|integer|min:1|max:9999',
            'is_active'        => 'required|boolean',
            'images'           => 'nullable|array',
            'images.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'default_image_id' => 'nullable|integer',
            'delete_images'    => 'nullable|array',
            'delete_images.*'  => 'integer',
        ]);

        DB::transaction(function () use ($request, $about) {
            $fiturArray = null;
            if ($request->filled('fitur')) {
                $fiturArray = array_values(array_filter(
                    array_map('trim', explode("\n", $request->fitur))
                ));
            }

            $about->update([
                'judul'             => $request->judul,
                'sub_judul'         => $request->sub_judul,
                'deskripsi_pendek'  => $request->deskripsi_pendek,
                'deskripsi_panjang' => $request->deskripsi_panjang,
                'fitur'             => $fiturArray,
                'tahun_mengabdi'    => $request->tahun_mengabdi,
                'is_active'         => $request->is_active,
            ]);

            // Hapus gambar yang dicentang untuk dihapus
            if ($request->filled('delete_images')) {
                $toDelete = AboutImage::where('about_id', $about->id)
                    ->whereIn('id', $request->delete_images)
                    ->get();
                foreach ($toDelete as $img) {
                    Storage::disk('public')->delete($img->path);
                    $img->delete();
                }
            }

            // Atur ulang default dari gambar yang ada
            if ($request->filled('default_image_id')) {
                AboutImage::where('about_id', $about->id)
                    ->update(['is_default' => false]);
                AboutImage::where('id', $request->default_image_id)
                    ->where('about_id', $about->id)
                    ->update(['is_default' => true]);
            }

            // Upload gambar baru
            if ($request->hasFile('images')) {
                $existingCount = $about->images()->count();
                $newDefaultIndex = (int) $request->input('new_default_index', -1);

                // Jika tidak ada gambar aktif dan user tidak set default_image_id,
                // maka gambar baru pertama jadi default
                $hasActiveDefault = AboutImage::where('about_id', $about->id)
                    ->where('is_default', true)->exists();

                foreach ($request->file('images') as $i => $file) {
                    $path = $file->store('abouts', 'public');
                    $isDefault = false;

                    if ($newDefaultIndex === $i) {
                        // Reset semua default lalu set yang ini
                        AboutImage::where('about_id', $about->id)->update(['is_default' => false]);
                        $isDefault = true;
                    } elseif (!$hasActiveDefault && $i === 0) {
                        $isDefault = true;
                    }

                    AboutImage::create([
                        'about_id'   => $about->id,
                        'path'       => $path,
                        'keterangan' => $request->new_keterangan[$i] ?? null,
                        'is_default' => $isDefault,
                        'urutan'     => $existingCount + $i,
                    ]);
                }
            }
        });

        Alert::success('Berhasil', 'Data about berhasil diperbarui.');
        return redirect()->route('abouts.index');
    }

    public function destroy(About $about)
    {
        // Hapus semua file gambar dari storage
        foreach ($about->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        $about->delete();

        Alert::success('Berhasil', 'Data about berhasil dihapus.');
        return redirect()->route('abouts.index');
    }

    /**
     * Hapus satu gambar via AJAX atau form (inline delete).
     */
    public function destroyImage(Request $request, AboutImage $aboutImage)
    {
        Storage::disk('public')->delete($aboutImage->path);
        $aboutImage->delete();

        Alert::success('Berhasil', 'Gambar berhasil dihapus.');
        return back();
    }

    /**
     * Set gambar sebagai default.
     */
    public function setDefaultImage(Request $request, AboutImage $aboutImage)
    {
        AboutImage::where('about_id', $aboutImage->about_id)
            ->update(['is_default' => false]);
        $aboutImage->update(['is_default' => true]);

        Alert::success('Berhasil', 'Gambar default berhasil diperbarui.');
        return back();
    }
}
