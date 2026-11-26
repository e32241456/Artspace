<?php

namespace App\Http\Controllers;

use App\Models\KaryaSeni;
use App\Models\KategoriKarya;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KaryaSeniController extends Controller
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
                        ->orWhere('deskripsi', 'ILIKE', "%{$kataKunci}%")
                        ->orWhere('media_bahan', 'ILIKE', "%{$kataKunci}%")
                        ->orWhereHas('seniman', fn ($sq) => $sq->where('nama_lengkap', 'ILIKE', "%{$kataKunci}%"));
                });
            })
            ->latest()
            ->get();

        return view('karya.jelajahi', [
            'judul_halaman' => 'Jelajahi Karya Seni — ARTSPACE',
            'daftar_karya' => $daftarKarya,
            'daftar_kategori' => KategoriKarya::query()->orderBy('nama')->get(),
            'kata_kunci' => $kataKunci,
            'kategori_aktif' => $kategoriSlug,
        ]);
    }

    public function detail(string $slug): View
    {
        $karya = KaryaSeni::with(['seniman', 'kategori'])
            ->terbit()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('karya.detail', [
            'judul_halaman' => $karya->judul . ' — ARTSPACE',
            'karya' => $karya,
            'seniman' => $karya->seniman,
        ]);
    }
}
