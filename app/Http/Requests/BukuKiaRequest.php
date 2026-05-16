<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuKiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profil_ibu_id'           => 'required|exists:profil_ibus,id',
            'fasilitas_kesehatan_id'  => 'required|exists:fasilitas_kesehatans,id',
            'no_reg_kohort_ibu'       => 'required|string|max:100',
            'no_reg_kohort_bayi'      => 'required|string|max:100',
            'no_reg_kohort_balita'    => 'required|string|max:100',
            'kehamilan_ke'            => 'required|numeric|min:1',
            'jumlah_anak_hidup'       => 'required|numeric|min:0',
            'riwayat_keguguran'       => 'required|string|max:100',
            'riwayat_penyakit'        => 'nullable|string|max:255',
            'no_catatan_medik_rs'     => 'nullable|string|max:100',
            'status'                  => 'required|in:Aktif,Tidak Aktif',
            'diterbitkan_pada'        => 'required|string|max:100',
            'diterbitkan_oleh'        => 'required|string|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'profil_ibu_id.required'          => 'Profil Ibu harus dipilih.',
            'fasilitas_kesehatan_id.required'  => 'Fasilitas Kesehatan harus dipilih.',
            'no_reg_kohort_ibu.required'       => 'No. Reg Kohort Ibu harus diisi.',
            'no_reg_kohort_bayi.required'      => 'No. Reg Kohort Bayi harus diisi.',
            'no_reg_kohort_balita.required'    => 'No. Reg Kohort Balita harus diisi.',
            'kehamilan_ke.required'            => 'Kehamilan ke- harus diisi.',
            'jumlah_anak_hidup.required'       => 'Jumlah anak hidup harus diisi.',
            'riwayat_keguguran.required'       => 'Riwayat keguguran harus diisi.',
            'status.required'                  => 'Status harus dipilih.',
            'diterbitkan_pada.required'        => 'Diterbitkan pada harus diisi.',
            'diterbitkan_oleh.required'        => 'Diterbitkan oleh harus diisi.',
        ];
    }
}
