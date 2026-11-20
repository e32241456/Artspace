<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Seniman extends Model
{
    protected $table = 'seniman';

    protected $fillable = [
        'pengguna_id',
        'slug',
        'nama_lengkap',
        'kota',
        'disiplin',
        'foto_profil',
        'biografi_singkat',
        'biografi',
        'latar_belakang',
        'perjalanan_berkesenian',
        'pengalaman',
    ];

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function karyaSeni(): HasMany
    {
        return $this->hasMany(KaryaSeni::class, 'seniman_id');
    }

    public function riwayatPameran(): HasMany
    {
        return $this->hasMany(RiwayatPameran::class, 'seniman_id')->orderByDesc('tahun');
    }

    public function getUrlFotoAttribute(): string
    {
        if (! $this->foto_profil) {
            return asset('images/artist_studio_portrait_1795137301009.jpg');
        }

        if (Str::startsWith($this->foto_profil, ['http://', 'https://', '/'])) {
            return $this->foto_profil;
        }

        if (Str::startsWith($this->foto_profil, 'images/')) {
            return asset($this->foto_profil);
        }

        return asset('storage/' . ltrim($this->foto_profil, '/'));
    }

    public function hitungKelengkapanProfil(): int
    {
        $kolom = [
            $this->nama_lengkap,
            $this->kota,
            $this->disiplin,
            $this->foto_profil,
            $this->biografi_singkat,
            $this->biografi,
            $this->latar_belakang,
            $this->perjalanan_berkesenian,
            $this->pengalaman,
        ];

        $terisi = count(array_filter($kolom, fn ($nilai) => filled($nilai)));

        return (int) round(($terisi / count($kolom)) * 100);
    }
}
