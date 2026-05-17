<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('POST')) {
            return [
                'buku_kia_id'    => 'required|exists:buku_kias,id',
                'items'          => 'required|array|min:1',
                'items.*.jenis'  => 'required|string|max:100',
                'items.*.file'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ];
        }

        return [
            'buku_kia_id'       => 'required|exists:buku_kias,id',
            'jenis_dokumen'     => 'required|string|max:100',
            'file'              => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status_verifikasi' => 'nullable|string|in:pending,verified,rejected',
        ];
    }

    public function messages(): array
    {
        return [
            'buku_kia_id.required'   => 'Buku KIA wajib dipilih.',
            'items.required'         => 'Minimal satu dokumen harus diunggah.',
            'items.*.jenis.required' => 'Jenis dokumen wajib diisi.',
            'items.*.file.required'  => 'File dokumen wajib diunggah.',
            'items.*.file.mimes'     => 'Format file harus pdf, jpg, jpeg, atau png.',
            'items.*.file.max'       => 'Ukuran file maksimal 2MB.',
        ];
    }
}
