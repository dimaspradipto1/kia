<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KonsultasiOnlineRequest extends FormRequest
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
        $userRole = auth()->user()->role->nama_role;

        // If the request is from a Nakes responding to the query
        if (in_array($userRole, ['nakes', 'administrator']) && $this->has('respons')) {
            return [
                'respons' => 'required|string|min:5',
                'status'  => 'required|in:accepted,rejected',
            ];
        }

        // If the request is from a Patient submitting/editing a question
        return [
            'fasilitas_kesehatan_id' => 'required|exists:fasilitas_kesehatans,id',
            'topik'                  => 'required|string|max:150|min:3',
            'pesan'                  => 'required|string|min:10',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'fasilitas_kesehatan_id.required' => 'Fasilitas kesehatan wajib dipilih.',
            'fasilitas_kesehatan_id.exists'   => 'Fasilitas kesehatan tidak valid.',
            'topik.required'                  => 'Topik keluhan/konsultasi wajib diisi.',
            'topik.max'                       => 'Topik tidak boleh lebih dari 150 karakter.',
            'topik.min'                       => 'Topik minimal berisi 3 karakter.',
            'pesan.required'                  => 'Detail keluhan wajib diisi.',
            'pesan.min'                       => 'Detail keluhan minimal berisi 10 karakter.',
            'respons.required'                => 'Jawaban medis wajib diisi.',
            'respons.min'                     => 'Jawaban medis minimal berisi 5 karakter.',
            'status.required'                 => 'Status tanggapan wajib ditentukan.',
        ];
    }
}
