<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPameran extends Model
{
    protected $table = 'riwayat_pameran';

    protected $fillable = [
        'seniman_id',
        'nama_pameran',
        'lokasi',
        'tahun',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
        ];
    }

    public function seniman(): BelongsTo
    {
        return $this->belongsTo(Seniman::class, 'seniman_id');
    }
}
