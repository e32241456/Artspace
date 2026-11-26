<?php

namespace App\Http\Controllers;

use App\Models\Seniman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SenimanController extends Controller
{
    public function index(Request $request): View
    {
        $kataKunci = trim($request->string('cari', '')->toString());

        $daftarSeniman = Seniman::query()
            ->withCount(['karyaSeni' => fn ($query) => $query->terbit()])
            ->when($kataKunci !== '', function ($query) use ($kataKunci) {
                $query->where(function ($sub) use ($kataKunci) {
                    $sub->where('nama_lengkap', 'ILIKE', "%{$kataKunci}%")
                        ->orWhere('kota', 'ILIKE', "%{$kataKunci}%")
                        ->orWhere('disiplin', 'ILIKE', "%{$kataKunci}%");
                });
            })
            ->orderBy('nama_lengkap')
            ->get();

        return view('seniman.daftar', [
            'judul_halaman' => 'Direktori Seniman — ARTSPACE',
            'daftar_seniman' => $daftarSeniman,
            'kata_kunci' => $kataKunci,
        ]);
    }

    public function profil(string $slug): View
    {
        $seniman = Seniman::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $seniman->load('riwayatPameran');
        $daftarKarya = $seniman->karyaSeni()
            ->with(['seniman', 'kategori'])
            ->terbit()
            ->latest()
            ->get();

        return view('seniman.profil', [
            'judul_halaman' => $seniman->nama_lengkap . ' — ARTSPACE',
            'seniman' => $seniman,
            'daftar_karya' => $daftarKarya,
            'riwayat_pameran' => $seniman->riwayatPameran,
        ]);
    }
}
