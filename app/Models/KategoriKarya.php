<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKarya extends Model
{
    protected $table = 'kategori_karya';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
    ];

    public function karyaSeni(): HasMany
    {
        return $this->hasMany(KaryaSeni::class, 'kategori_id');
    }
}
