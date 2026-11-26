<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpanKaryaSeniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->peran === 'seniman' && (bool) $this->user()?->aktif;
    }

    public function rules(): array
    {
        $fotoRules = $this->routeIs('dasbor.seniman.karya.simpan')
            ? ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']
            : ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];

        return [
            'judul' => ['required', 'string', 'max:180'],
            'kategori_id' => ['nullable', 'integer', 'exists:kategori_karya,id'],
            'deskripsi' => ['required', 'string'],
            'tahun_pembuatan' => ['required', 'integer', 'between:1900,2030'],
            'media_bahan' => ['required', 'string', 'max:500'],
            'dimensi' => ['nullable', 'string', 'max:150'],
            'informasi_tambahan' => ['nullable', 'string'],
            'harga_opsional' => ['nullable', 'numeric', 'min:0', 'max:9999999999999.99'],
            'foto_karya' => $fotoRules,
        ];
    }
}
