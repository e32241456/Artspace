<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerbaruiProfilSenimanRequest;
use App\Http\Requests\SimpanKaryaSeniRequest;
use App\Http\Requests\SimpanRiwayatPameranRequest;
use App\Models\KaryaSeni;
use App\Models\KategoriKarya;
use App\Models\RiwayatPameran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DasborSenimanController extends Controller
{
    public function index(Request $request): View
    {
        $seniman = $request->user()->seniman()->with([
            'karyaSeni' => fn ($q) => $q->with('kategori')->latest(),
            'riwayatPameran',
        ])->firstOrFail();

        return view('dasbor-seniman.index', [
            'judul_halaman' => 'Dasbor Seniman — ARTSPACE',
            'seniman' => $seniman,
            'daftar_karya' => $seniman->karyaSeni,
            'riwayat_pameran' => $seniman->riwayatPameran,
            'daftar_kategori' => KategoriKarya::query()->orderBy('nama')->get(),
            'kelengkapan_profil' => $seniman->hitungKelengkapanProfil(),
        ]);
    }

    public function perbaruiProfil(PerbaruiProfilSenimanRequest $request): RedirectResponse
    {
        $seniman = $request->user()->seniman()->firstOrFail();
        $data = $request->validated();

        if ($request->hasFile('foto_profil')) {
            if ($seniman->foto_profil && Storage::disk('public')->exists($seniman->foto_profil)) {
                Storage::disk('public')->delete($seniman->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('profil-seniman', 'public');
        } else {
            unset($data['foto_profil']);
        }

        $seniman->update($data);
        $request->user()->update(['nama' => $data['nama_lengkap']]);

        return back()->with('sukses', 'Profil seniman berhasil diperbarui.');
    }

    public function simpanKarya(SimpanKaryaSeniRequest $request): RedirectResponse
    {
        $seniman = $request->user()->seniman()->firstOrFail();
        $data = $request->validated();

        $pathFoto = $request->file('foto_karya')->store('karya-seni', 'public');
        $slug = Str::slug($data['judul']) . '-' . Str::lower(Str::random(5));

        $seniman->karyaSeni()->create([
            'kategori_id' => $data['kategori_id'] ?? null,
            'slug' => $slug,
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'tahun_pembuatan' => $data['tahun_pembuatan'],
            'media_bahan' => $data['media_bahan'],
            'dimensi' => $data['dimensi'] ?? null,
            'informasi_tambahan' => $data['informasi_tambahan'] ?? null,
            'harga_opsional' => $data['harga_opsional'] ?? null,
            'foto_karya' => $pathFoto,
            'status' => KaryaSeni::STATUS_TERBIT, // Langsung TERBIT tanpa menunggu persetujuan Admin
        ]);

        return back()->with('sukses', 'Karya seni berhasil ditambahkan dan langsung terbit di katalog publik.');
    }

    public function perbaruiKarya(SimpanKaryaSeniRequest $request, KaryaSeni $karya): RedirectResponse
    {
        Gate::authorize('perbarui', $karya);
        $data = $request->validated();

        if ($request->hasFile('foto_karya')) {
            if ($karya->foto_karya && Storage::disk('public')->exists($karya->foto_karya)) {
                Storage::disk('public')->delete($karya->foto_karya);
            }
            $data['foto_karya'] = $request->file('foto_karya')->store('karya-seni', 'public');
        } else {
            unset($data['foto_karya']);
        }

        $karya->update($data);

        return back()->with('sukses', 'Informasi karya seni berhasil diperbarui.');
    }

    public function hapusKarya(KaryaSeni $karya): RedirectResponse
    {
        Gate::authorize('hapus', $karya);

        if ($karya->foto_karya && Storage::disk('public')->exists($karya->foto_karya)) {
            Storage::disk('public')->delete($karya->foto_karya);
        }

        $karya->delete();

        return back()->with('sukses', 'Karya seni telah dihapus dari portofolio Anda.');
    }

    public function simpanPameran(SimpanRiwayatPameranRequest $request): RedirectResponse
    {
        $seniman = $request->user()->seniman()->firstOrFail();
        $seniman->riwayatPameran()->create($request->validated());

        return back()->with('sukses', 'Riwayat pameran berhasil ditambahkan ke profil Anda.');
    }

    public function perbaruiPameran(SimpanRiwayatPameranRequest $request, RiwayatPameran $riwayat): RedirectResponse
    {
        Gate::authorize('kelola', $riwayat);
        $riwayat->update($request->validated());

        return back()->with('sukses', 'Riwayat pameran berhasil diperbarui.');
    }

    public function hapusPameran(RiwayatPameran $riwayat): RedirectResponse
    {
        Gate::authorize('kelola', $riwayat);
        $riwayat->delete();

        return back()->with('sukses', 'Riwayat pameran berhasil dihapus.');
    }
}
