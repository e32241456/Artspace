<?php

namespace App\Policies;

use App\Models\KaryaSeni;
use App\Models\Pengguna;

class KaryaSeniPolicy
{
    public function perbarui(Pengguna $pengguna, KaryaSeni $karya): bool
    {
        return $pengguna->aktif
            && $pengguna->peran === 'seniman'
            && $pengguna->seniman()->whereKey($karya->seniman_id)->exists();
    }

    public function hapus(Pengguna $pengguna, KaryaSeni $karya): bool
    {
        return $this->perbarui($pengguna, $karya);
    }
}
