@extends('layouts.utama')

@section('konten')
  <section class="max-w-[1160px] mx-auto px-4 sm:px-6 lg:px-10 py-12 lg:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden">
      {{-- Panel Editorial Kiri --}}
      <div class="lg:col-span-5 bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] p-8 lg:p-10 flex flex-col justify-between">
        <div>
          <p class="label-caps text-[#D4A943]">PENDAFTARAN SENIMAN</p>
          <h1 class="mt-3 font-display text-3xl sm:text-4xl font-semibold leading-tight">
            Bangun Portofolio Digital Karya Seni Anda
          </h1>
          <div class="mt-5 h-[2px] w-14 bg-[#D4A943]"></div>
          <p class="mt-5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
            Setelah mendaftar, Anda dapat melengkapi biografi, mendokumentasikan riwayat pameran, serta menerbitkan karya langsung ke galeri publik ARTSPACE.
          </p>
        </div>

        <div class="mt-8 pt-6 border-t border-[#77805B]/40 dark:border-[#3A4637] space-y-2 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">
          <p>• Karya yang Anda unggah langsung berstatus <strong class="text-[#D4A943]">TERBIT</strong>.</p>
          <p>• Riwayat pameran tampil terpadu di halaman profil Anda.</p>
          <p>• Pendaftaran publik khusus untuk akun Seniman.</p>
        </div>
      </div>

      {{-- Formulir Pendaftaran Seniman Kanan --}}
      <div class="lg:col-span-7 bg-[#FBF9F2] dark:bg-[#293326] p-8 lg:p-12">
        <p class="label-caps text-[#354638] dark:text-[#A5B18A]">AKUN BARU SENIMAN</p>
        <h2 class="mt-2 font-display text-2xl sm:text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Daftar Akun Seniman</h2>

        @if($errors->any())
          <div class="mt-6 bg-[#7A271A]/10 dark:bg-[#7A271A]/30 border border-[#BA1A1A] text-[#7A271A] dark:text-[#FFDAD6] rounded-[0.25rem] p-4" role="alert">
            <p class="label-caps mb-2">PERIKSA KEMBALI FORMULIR PENDAFTARAN</p>
            <ul class="text-sm space-y-1">
              @foreach($errors->all() as $err)
                <li>— {{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('daftar.proses') }}" class="mt-7 space-y-5">
          @csrf

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
              <label for="nama_lengkap" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">NAMA LENGKAP SENIMAN *</label>
              <input
                id="nama_lengkap"
                name="nama_lengkap"
                type="text"
                required
                value="{{ old('nama_lengkap') }}"
                placeholder="Contoh: Kirana Larasati"
                class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
              />
            </div>

            <div>
              <label for="kota" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">KOTA DOMISILI *</label>
              <input
                id="kota"
                name="kota"
                type="text"
                required
                value="{{ old('kota') }}"
                placeholder="Contoh: Bandung"
                class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
              />
            </div>

            <div>
              <label for="disiplin" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">DISIPLIN BERKESENIAN *</label>
              <input
                id="disiplin"
                name="disiplin"
                type="text"
                required
                value="{{ old('disiplin') }}"
                placeholder="Lukisan, Patung, Fotografi..."
                class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
              />
            </div>

            <div class="sm:col-span-2">
              <label for="surel" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">ALAMAT SUREL *</label>
              <input
                id="surel"
                name="surel"
                type="email"
                required
                value="{{ old('surel') }}"
                placeholder="seniman@contoh.id"
                class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
              />
            </div>

            <div>
              <label for="kata_sandi" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">KATA SANDI (MIN. 8 KARAKTER) *</label>
              <input
                id="kata_sandi"
                name="kata_sandi"
                type="password"
                required
                minlength="8"
                placeholder="Minimal 8 karakter"
                class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
              />
            </div>

            <div>
              <label for="kata_sandi_confirmation" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">KONFIRMASI KATA SANDI *</label>
              <input
                id="kata_sandi_confirmation"
                name="kata_sandi_confirmation"
                type="password"
                required
                minlength="8"
                placeholder="Ulangi kata sandi"
                class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
              />
            </div>
          </div>

          <button type="submit" class="w-full py-3.5 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
            Buat Akun Seniman
          </button>
        </form>

        <div class="mt-8 pt-6 border-t border-[#D6D1C2] dark:border-[#3A4637] flex flex-wrap items-center justify-between gap-3 text-sm">
          <span class="text-[#68705C] dark:text-[#B8BDAA]">Sudah memiliki akun terdaftar?</span>
          <a href="{{ route('masuk') }}" class="font-semibold text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
            Masuk di Sini →
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection
