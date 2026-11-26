<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerbaruiProfilSenimanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->peran === 'seniman' && (bool) $this->user()?->aktif;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'kota' => ['required', 'string', 'max:120'],
            'disiplin' => ['required', 'string', 'max:180'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'biografi_singkat' => ['required', 'string', 'max:500'],
            'biografi' => ['required', 'string'],
            'latar_belakang' => ['nullable', 'string'],
            'perjalanan_berkesenian' => ['nullable', 'string'],
            'pengalaman' => ['nullable', 'string'],
        ];
    }
}
