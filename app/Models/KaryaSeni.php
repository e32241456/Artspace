<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class KaryaSeni extends Model
{
    protected $table = 'karya_seni';

    public const STATUS_TERBIT = 'TERBIT';
    public const STATUS_DITANGGUHKAN = 'DITANGGUHKAN';

    protected $fillable = [
        'seniman_id',
        'kategori_id',
        'slug',
        'judul',
        'deskripsi',
        'tahun_pembuatan',
        'media_bahan',
        'dimensi',
        'informasi_tambahan',
        'harga_opsional',
        'foto_karya',
        'status',
        'catatan_moderasi',
    ];

    public function seniman(): BelongsTo
    {
        return $this->belongsTo(Seniman::class, 'seniman_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriKarya::class, 'kategori_id');
    }

    public function scopeTerbit(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_TERBIT);
    }

    public function getUrlFotoAttribute(): string
    {
        if (! $this->foto_karya) {
            return asset('images/artwork_terracotta_monolith_1795137300116.jpg');
        }

        if (Str::startsWith($this->foto_karya, ['http://', 'https://', '/'])) {
            return $this->foto_karya;
        }

        if (Str::startsWith($this->foto_karya, 'images/')) {
            return asset($this->foto_karya);
        }

        return asset('storage/' . ltrim($this->foto_karya, '/'));
    }

    public function getHargaTerformatAttribute(): ?string
    {
        if ($this->harga_opsional === null) {
            return null;
        }

        return 'Rp ' . number_format($this->harga_opsional, 0, ',', '.');
    }
}
