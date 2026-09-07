<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilSuamiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $profilSuami = $this->route('profilSuami') ?? $this->route('profil_suami');
        $profilSuamiId = is_object($profilSuami) ? $profilSuami->id : $profilSuami;

        return [
            'profil_ibu_id' => 'required|exists:profil_ibus,id',
            'nik' => 'required|numeric|digits:16|unique:profil_suamis,nik,' . ($profilSuamiId ?? 'NULL'),
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'nullable|string|max:5',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'nomor_wa' => 'nullable|numeric|digits_between:10,15',
        ];
    }

    public function messages(): array
    {
        return [
            'profil_ibu_id.required' => 'Profil Ibu harus dipilih.',
            'nik.required' => 'NIK harus diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'tempat_lahir.required' => 'Tempat lahir harus diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'nomor_wa.numeric' => 'Nomor WhatsApp harus berupa angka.',
        ];
    }
}
