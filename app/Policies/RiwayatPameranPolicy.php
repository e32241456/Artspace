<?php

namespace App\Policies;

use App\Models\Pengguna;
use App\Models\RiwayatPameran;

class RiwayatPameranPolicy
{
    public function kelola(Pengguna $pengguna, RiwayatPameran $riwayat): bool
    {
        return $pengguna->aktif
            && $pengguna->peran === 'seniman'
            && $pengguna->seniman()->whereKey($riwayat->seniman_id)->exists();
    }
}
