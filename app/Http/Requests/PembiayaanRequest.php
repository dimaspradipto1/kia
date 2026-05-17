<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembiayaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profil_ibu_id'    => 'required|exists:profil_ibus,id',
            'jenis_pembiayaan' => 'required|string|max:100',
            'nama_asuransi'    => 'nullable|string|max:150',
            'nomor_polis'      => 'nullable|string|max:100',
            'tanggal_berlaku'  => 'nullable|date',
            // is_active ditangani manual di controller (checkbox HTML mengirim "on", bukan boolean)
        ];
    }

    public function messages(): array
    {
        return [
            'profil_ibu_id.required'    => 'Profil ibu wajib dipilih.',
            'jenis_pembiayaan.required' => 'Jenis pembiayaan wajib diisi.',
        ];
    }
}
