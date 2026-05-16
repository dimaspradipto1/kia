<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FasilitasKesehatanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_faskes' => 'required|string|max:255',
            'jenis' => 'required|string|max:100',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:100',
            'kab_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'telepon' => 'required|numeric|digits_between:10,15',
            'jam_buka' => 'nullable|string|max:10',
            'jam_tutup' => 'nullable|string|max:10',
            'embed_map' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nama_faskes.required' => 'Nama Fasilitas Kesehatan wajib diisi.',
            'jenis.required' => 'Jenis Fasilitas Kesehatan wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kab_kota.required' => 'Kabupaten/Kota wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.numeric' => 'Nomor telepon harus berupa angka.',
            'telepon.digits_between' => 'Nomor telepon harus antara 10 sampai 15 digit.',
            'is_active.required' => 'Status aktif wajib dipilih.',
        ];
    }
}
