<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilAnakRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'buku_kia_id'          => 'required|exists:buku_kias,id',
            'nama_lengkap'         => 'required|string|max:255',
            'jenis_kelamin'        => 'required|in:Laki-laki,Perempuan',
            'anak_ke'              => 'required|numeric|min:1',
            'tempat_lahir'         => 'required|string|max:100',
            'tanggal_lahir'        => 'required|date',
            'golongan_darah'       => 'nullable|string|max:5',
            'nomor_akta_kelahiran' => 'nullable|string|max:50',
            'berat_lahir_kg'       => 'nullable|numeric',
            'panjang_lahir_cm'     => 'nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'buku_kia_id.required'   => 'Buku KIA harus dipilih.',
            'nama_lengkap.required'  => 'Nama lengkap harus diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'anak_ke.required'       => 'Anak ke- harus diisi.',
            'tempat_lahir.required'  => 'Tempat lahir harus diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
        ];
    }
}
