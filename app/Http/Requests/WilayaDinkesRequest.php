<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WilayaDinkesRequest extends FormRequest
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
        $id = $this->route('wilaya_dinke') ? $this->route('wilaya_dinke')->id : null;

        return [
            'kode_dinkes' => 'required|string|max:255|unique:wilaya_dinkes,kode_dinkes,' . $id,
            'nama_dinkes' => 'required|string',
            'tipe_dinkes' => 'required|string|max:255',
        ];
    }
}
