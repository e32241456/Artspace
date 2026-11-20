<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'surel',
        'kata_sandi',
        'peran',
        'aktif',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
            'kata_sandi' => 'hashed',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'kata_sandi';
    }

    public function getAuthPassword(): string
    {
        return $this->kata_sandi;
    }

    public function seniman(): HasOne
    {
        return $this->hasOne(Seniman::class, 'pengguna_id');
    }

    public function adalahAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function adalahSeniman(): bool
    {
        return $this->peran === 'seniman';
    }
}
