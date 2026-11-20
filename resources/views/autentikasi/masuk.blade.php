@extends('layouts.utama')

@section('konten')
  <section class="max-w-[1160px] mx-auto px-4 sm:px-6 lg:px-10 py-12 lg:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden">
      {{-- Panel Editorial Kiri (Forest Olive & Mustard) --}}
      <div class="lg:col-span-5 bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] p-8 lg:p-10 flex flex-col justify-between">
        <div>
          <p class="label-caps text-[#D4A943]">AKSES AKUN ARTSPACE</p>
          <h1 class="mt-3 font-display text-3xl sm:text-4xl font-semibold leading-tight">
            Masuk ke Ruang Portofolio & Moderasi
          </h1>
          <div class="mt-5 h-[2px] w-14 bg-[#D4A943]"></div>
          <p class="mt-5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
            Masuk sebagai Seniman untuk mengelola profil, karya seni, dan riwayat pameran, atau sebagai Admin untuk memantau konten dan laporan sistem. Pengunjung publik tetap bebas menjelajahi karya tanpa masuk.
          </p>
        </div>

        {{-- Panduan Akun Seeder --}}
        <div class="mt-8 bg-[#29382D] dark:bg-[#293326] border border-[#D4A943]/50 rounded-[0.25rem] p-5 space-y-3">
          <p class="label-caps text-[#D4A943]">AKUN DEMONSTRASI SEEDER</p>
          <div class="text-xs space-y-2 text-[#EAE5D5] dark:text-[#B8BDAA]">
            <div>
              <p class="font-semibold text-[#FBF9F2]">Seniman (Baskoro Wijaya)</p>
              <p class="tabular-nums">Surel: <code class="text-[#D4A943]">baskoro@artspace.id</code> · Sandi: <code class="text-[#D4A943]">artspace123</code></p>
            </div>
            <div class="pt-2 border-t border-[#77805B]/30">
              <p class="font-semibold text-[#FBF9F2]">Administrator Sistem</p>
              <p class="tabular-nums">Surel: <code class="text-[#D4A943]">admin@artspace.id</code> · Sandi: <code class="text-[#D4A943]">admin123</code></p>
            </div>
          </div>
        </div>
      </div>

      {{-- Formulir Masuk Kanan --}}
      <div class="lg:col-span-7 bg-[#FBF9F2] dark:bg-[#293326] p-8 lg:p-12">
        <p class="label-caps text-[#354638] dark:text-[#A5B18A]">AUTENTIKASI PENGGUNA</p>
        <h2 class="mt-2 font-display text-2xl sm:text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Masuk ke Akun Anda</h2>

        @if($errors->any())
          <div class="mt-6 bg-[#7A271A]/10 dark:bg-[#7A271A]/30 border border-[#BA1A1A] text-[#7A271A] dark:text-[#FFDAD6] rounded-[0.25rem] p-4" role="alert">
            <p class="label-caps mb-2">PERIKSA KEMBALI DATA MASUK</p>
            <ul class="text-sm space-y-1">
              @foreach($errors->all() as $err)
                <li>— {{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('masuk.proses') }}" class="mt-7 space-y-5">
          @csrf

          <div>
            <label for="surel" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">ALAMAT SUREL *</label>
            <input
              id="surel"
              name="surel"
              type="email"
              required
              value="{{ old('surel') }}"
              placeholder="nama@artspace.id"
              class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
            />
          </div>

          <div>
            <label for="kata_sandi" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">KATA SANDI *</label>
            <input
              id="kata_sandi"
              name="kata_sandi"
              type="password"
              required
              placeholder="Masukkan kata sandi Anda"
              class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
            />
          </div>

          <div class="flex items-center gap-2">
            <input id="ingat_saya" name="ingat_saya" type="checkbox" value="1" class="accent-[#354638] dark:accent-[#D4A943]" />
            <label for="ingat_saya" class="text-xs text-[#68705C] dark:text-[#B8BDAA]">Tetap masuk pada peramban ini</label>
          </div>

          <button type="submit" class="w-full py-3.5 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
            Masuk ke ARTSPACE
          </button>
        </form>

        <div class="mt-8 pt-6 border-t border-[#D6D1C2] dark:border-[#3A4637] flex flex-wrap items-center justify-between gap-3 text-sm">
          <span class="text-[#68705C] dark:text-[#B8BDAA]">Belum memiliki akun seniman?</span>
          <a href="{{ route('daftar') }}" class="font-semibold text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
            Daftar sebagai Seniman →
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection
