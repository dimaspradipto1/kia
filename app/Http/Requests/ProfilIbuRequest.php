<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilIbuRequest extends FormRequest
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
        $profilIbuId = $this->route('profil_ibu') ? $this->route('profil_ibu')->id : null;

        return [
            'user_id' => 'required|exists:users,id',
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'nik' => 'required|numeric|digits:16|unique:profil_ibus,nik,' . $profilIbuId,
            'nama_lengkap' => 'required|string|max:255',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'nullable|string|max:5',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string|max:50',
            'nomor_wa' => 'nullable|numeric|digits_between:10,15',
            'nomor_jkn' => 'nullable|numeric|digits_between:10,20',
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
            'user_id.required' => 'Pilih pengguna terlebih dahulu.',
            'fasilitas_kesehatan_id.required' => 'Pilih Fasilitas Kesehatan terlebih dahulu.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus berjumlah 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'nomor_wa.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'nomor_wa.digits_between' => 'Nomor WhatsApp harus antara 10 sampai 15 digit.',
            'nomor_jkn.numeric' => 'Nomor JKN harus berupa angka.',
        ];
    }
}
