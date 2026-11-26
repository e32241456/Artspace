<?php

namespace App\Http\Controllers;

use App\Models\KaryaSeni;
use App\Models\KategoriKarya;
use App\Models\Pengguna;
use App\Models\Seniman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DasborAdminController extends Controller
{
    public function index(): View
    {
        $totalSemuaKarya = max(1, KaryaSeni::query()->count());

        $ringkasan = [
            'total_pengguna' => Pengguna::query()->count(),
            'total_seniman' => Seniman::query()->count(),
            'total_karya_terbit' => KaryaSeni::query()->where('status', KaryaSeni::STATUS_TERBIT)->count(),
            'total_karya_ditangguhkan' => KaryaSeni::query()->where('status', KaryaSeni::STATUS_DITANGGUHKAN)->count(),
        ];

        $laporanKategori = KategoriKarya::query()
            ->withCount('karyaSeni')
            ->orderByDesc('karya_seni_count')
            ->get()
            ->map(function (KategoriKarya $kat) use ($totalSemuaKarya) {
                $kat->setAttribute('persentase', (int) round(($kat->karya_seni_count / $totalSemuaKarya) * 100));

                return $kat;
            });

        return view('dasbor-admin.index', [
            'judul_halaman' => 'Dasbor Admin — ARTSPACE',
            'ringkasan' => $ringkasan,
            'daftar_pengguna' => Pengguna::query()->latest()->get(),
            'daftar_seniman' => Seniman::withCount(['karyaSeni', 'riwayatPameran'])->latest()->get(),
            'daftar_karya' => KaryaSeni::with(['seniman', 'kategori'])->latest()->get(),
            'laporan_kategori' => $laporanKategori,
        ]);
    }

    public function ubahStatusPengguna(Pengguna $pengguna): RedirectResponse
    {
        if ($pengguna->adalahAdmin()) {
            return back()->with('galat', 'Status akun administrator utama tidak dapat dinonaktifkan.');
        }

        $pengguna->update(['aktif' => ! $pengguna->aktif]);

        $label = $pengguna->aktif ? 'diaktifkan kembali' : 'dinonaktifkan';

        return back()->with('sukses', "Akun {$pengguna->nama} berhasil {$label}.");
    }

    public function moderasiKarya(Request $request, KaryaSeni $karya): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:TERBIT,DITANGGUHKAN'],
            'catatan_moderasi' => ['nullable', 'string', 'max:500'],
        ]);

        $karya->update([
            'status' => $data['status'],
            'catatan_moderasi' => $data['status'] === KaryaSeni::STATUS_DITANGGUHKAN
                ? (($data['catatan_moderasi'] ?? null) ?: 'Konten ditangguhkan karena melanggar ketentuan kurasi ARTSPACE.')
                : null,
                ]);

        return back()->with('sukses', "Status publikasi karya \"{$karya->judul}\" diperbarui menjadi {$data['status']}.");
    }

    public function hapusKaryaPelanggaran(KaryaSeni $karya): RedirectResponse
    {
        $judul = $karya->judul;

        if ($karya->foto_karya && Storage::disk('public')->exists($karya->foto_karya)) {
            Storage::disk('public')->delete($karya->foto_karya);
        }

        $karya->delete();

        return back()->with('sukses', "Karya \"{$judul}\" telah dihapus permanen dari sistem.");
    }
}
