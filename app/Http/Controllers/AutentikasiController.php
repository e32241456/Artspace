<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AutentikasiController extends Controller
{
    public function formMasuk(): View
    {
        return view('autentikasi.masuk', ['judul_halaman' => 'Masuk — ARTSPACE']);
    }

    public function prosesMasuk(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'surel' => ['required', 'email'],
            'kata_sandi' => ['required', 'string'],
        ], [
            'surel.required' => 'Alamat surel wajib diisi.',
            'surel.email' => 'Format alamat surel tidak valid.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
        ]);

        $berhasil = Auth::attempt([
            'surel' => $data['surel'],
            'password' => $data['kata_sandi'],
        ], $request->boolean('ingat_saya'));

        if (! $berhasil) {
            throw ValidationException::withMessages([
                'surel' => 'Alamat surel atau kata sandi tidak sesuai.',
            ]);
        }

        $pengguna = Auth::user();

        if (! $pengguna->aktif) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withInput($request->only('surel'))
                ->with('galat', 'Akun Anda sedang dinonaktifkan oleh administrator.');
        }

        $request->session()->regenerate();

        return match ($pengguna->peran) {
            'admin' => redirect()->intended(route('dasbor.admin')),
            'seniman' => $pengguna->seniman()->exists()
                ? redirect()->intended(route('dasbor.seniman'))
                : redirect()->route('beranda')->with('galat', 'Profil seniman belum tersedia. Hubungi administrator.'),
            default => tap(redirect()->route('beranda'), fn () => Auth::logout()),
        };
    }

    public function formDaftar(): View
    {
        return view('autentikasi.daftar', ['judul_halaman' => 'Daftar Seniman — ARTSPACE']);
    }

    public function prosesDaftar(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'kota' => ['required', 'string', 'max:120'],
            'disiplin' => ['required', 'string', 'max:180'],
            'surel' => ['required', 'email', 'max:180', 'unique:pengguna,surel'],
            'kata_sandi' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'surel.unique' => 'Alamat surel sudah terdaftar.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $pengguna = DB::transaction(function () use ($data) {
            $pengguna = Pengguna::create([
                'nama' => $data['nama_lengkap'],
                'surel' => $data['surel'],
                'kata_sandi' => $data['kata_sandi'],
                'peran' => 'seniman',
                'aktif' => true,
            ]);

            $dasarSlug = Str::slug($data['nama_lengkap']) ?: 'seniman';
            $slug = $dasarSlug . '-' . Str::lower(Str::random(6));

            $pengguna->seniman()->create([
                'slug' => $slug,
                'nama_lengkap' => $data['nama_lengkap'],
                'kota' => $data['kota'],
                'disiplin' => $data['disiplin'],
            ]);

            return $pengguna;
        });

        Auth::login($pengguna);
        $request->session()->regenerate();

        return redirect()->route('dasbor.seniman')
            ->with('sukses', 'Pendaftaran berhasil. Selamat datang di ARTSPACE.');
    }

    public function keluar(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda')->with('sukses', 'Anda berhasil keluar dari ARTSPACE.');
    }
}
