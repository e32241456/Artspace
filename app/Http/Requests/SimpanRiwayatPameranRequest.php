<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanRiwayatPameranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->peran === 'seniman' && (bool) $this->user()?->aktif;
    }

    public function rules(): array
    {
        return [
            'nama_pameran' => ['required', 'string', 'max:180'],
            'lokasi' => ['required', 'string', 'max:180'],
            'tahun' => ['required', 'integer', 'between:1950,2030'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
