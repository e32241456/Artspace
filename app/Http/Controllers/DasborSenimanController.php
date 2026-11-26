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
    /**
     * Menyimpan foto ke Supabase Storage.
     */
    private function simpanFoto($file, string $folder): string
    {
        $path = $file->store($folder, 'supabase');

        return 'supabase/' . $path;
    }

    /**
     * Menghapus foto lama dari lokasi penyimpanannya.
     */
    private function hapusFotoLama(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (Str::startsWith($path, 'supabase/')) {
            Storage::disk('supabase')->delete(substr($path, 9));
            return;
        }

        Storage::disk('public')->delete($path);
    }

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
        $fotoLama = $seniman->foto_profil;

        if ($request->hasFile('foto_profil')) {
            $data['foto_profil'] = $this->simpanFoto(
                $request->file('foto_profil'),
                'profil-seniman'
            );
        } else {
            unset($data['foto_profil']);
        }

        $seniman->update($data);
        $request->user()->update(['nama' => $data['nama_lengkap']]);

        if (isset($data['foto_profil'])) {
            $this->hapusFotoLama($fotoLama);
        }

        return back()->with('sukses', 'Profil seniman berhasil diperbarui.');
    }

    public function simpanKarya(SimpanKaryaSeniRequest $request): RedirectResponse
    {
        $seniman = $request->user()->seniman()->firstOrFail();
        $data = $request->validated();

        $pathFoto = $this->simpanFoto(
            $request->file('foto_karya'),
            'karya-seni'
        );

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
            'status' => KaryaSeni::STATUS_TERBIT,
        ]);

        return back()->with('sukses', 'Karya seni berhasil ditambahkan dan langsung terbit di katalog publik.');
    }

    public function perbaruiKarya(SimpanKaryaSeniRequest $request, KaryaSeni $karya): RedirectResponse
    {
        Gate::authorize('perbarui', $karya);

        $data = $request->validated();
        $fotoLama = $karya->foto_karya;

        if ($request->hasFile('foto_karya')) {
            $data['foto_karya'] = $this->simpanFoto(
                $request->file('foto_karya'),
                'karya-seni'
            );
        } else {
            unset($data['foto_karya']);
        }

        if ($data['judul'] !== $karya->judul) {
            $data['slug'] = Str::slug($data['judul']) . '-' . Str::lower(Str::random(5));
        }

        $karya->update($data);

        if (isset($data['foto_karya'])) {
            $this->hapusFotoLama($fotoLama);
        }

        return back()->with('sukses', 'Informasi karya seni berhasil diperbarui.');
    }

    public function hapusKarya(KaryaSeni $karya): RedirectResponse
    {
        Gate::authorize('hapus', $karya);

        $foto = $karya->foto_karya;

        $karya->delete();

        $this->hapusFotoLama($foto);

        return back()->with('sukses', 'Karya seni telah dihapus dari portofolio Anda.');
    }

    public function simpanPameran(SimpanRiwayatPameranRequest $request): RedirectResponse
    {
        $seniman = $request->user()->seniman()->firstOrFail();
        $seniman->riwayatPameran()->create($request->validated());

        return redirect()->route('dasbor.seniman', ['tab' => 'pameran'])
            ->with('sukses', 'Riwayat pameran berhasil ditambahkan ke profil Anda.');
    }

    public function perbaruiPameran(
        SimpanRiwayatPameranRequest $request,
        RiwayatPameran $riwayat
    ): RedirectResponse {
        Gate::authorize('kelola', $riwayat);
        $riwayat->update($request->validated());

        return redirect()->route('dasbor.seniman', ['tab' => 'pameran'])
            ->with('sukses', 'Riwayat pameran berhasil diperbarui.');
    }

    public function hapusPameran(RiwayatPameran $riwayat): RedirectResponse
    {
        Gate::authorize('kelola', $riwayat);
        $riwayat->delete();

        return redirect()->route('dasbor.seniman', ['tab' => 'pameran'])
            ->with('sukses', 'Riwayat pameran berhasil dihapus.');
    }
}
