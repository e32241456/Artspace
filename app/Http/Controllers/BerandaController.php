<?php

namespace App\Http\Controllers;

use App\Models\KaryaSeni;
use App\Models\KategoriKarya;
use App\Models\Seniman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BerandaController extends Controller
{
    public function index(Request $request): View
    {
        $kataKunci = trim($request->string('cari', '')->toString());
        $kategoriSlug = $request->string('kategori', 'semua')->toString();

        $daftarKarya = KaryaSeni::with(['seniman', 'kategori'])
            ->terbit()
            ->when($kategoriSlug !== 'semua', function ($query) use ($kategoriSlug) {
                $query->whereHas('kategori', fn ($q) => $q->where('slug', $kategoriSlug));
            })
            ->when($kataKunci !== '', function ($query) use ($kataKunci) {
                $query->where(function ($sub) use ($kataKunci) {
                    $sub->where('judul', 'ILIKE', "%{$kataKunci}%")
                        ->orWhere('media_bahan', 'ILIKE', "%{$kataKunci}%")
                        ->orWhereHas('seniman', fn ($sq) => $sq->where('nama_lengkap', 'ILIKE', "%{$kataKunci}%"));
                });
            })
            ->latest()
            ->get();

        $senimanCocok = $kataKunci !== ''
            ? Seniman::withCount(['karyaSeni' => fn ($q) => $q->terbit()])
                ->where(function ($sub) use ($kataKunci) {
                    $sub->where('nama_lengkap', 'ILIKE', "%{$kataKunci}%")
                        ->orWhere('disiplin', 'ILIKE', "%{$kataKunci}%")
                        ->orWhere('kota', 'ILIKE', "%{$kataKunci}%");
                })
                ->limit(6)
                ->get()
            : collect();

        return view('beranda', [
            'judul_halaman' => 'ARTSPACE — Jelajahi Karya Seni & Profil Seniman',
            'daftar_karya' => $daftarKarya,
            'daftar_kategori' => KategoriKarya::query()->orderBy('nama')->get(),
            'seniman_cocok' => $senimanCocok,
            'kata_kunci' => $kataKunci,
            'kategori_aktif' => $kategoriSlug,
            'total_karya' => KaryaSeni::query()->terbit()->count(),
            'total_seniman' => Seniman::query()->count(),
        ]);
    }
}
