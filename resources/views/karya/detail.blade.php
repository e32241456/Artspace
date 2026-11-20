@extends('layouts.utama')

@section('konten')
  {{-- Halaman Detail Karya Dua Kolom Bergaya Pin Pinterest (Tanpa Fitur Transaksi, Tanpa Komentar, Tanpa Rekomendasi di Bawah) --}}
  <section class="max-w-[1320px] mx-auto px-4 sm:px-6 lg:px-10 py-8 lg:py-12">
    {{-- Baris Navigasi Kembali --}}
    <div class="mb-6 flex items-center justify-between gap-4">
      <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#EAE5D5] dark:bg-[#20291F] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] text-xs font-semibold uppercase tracking-[0.1em] text-[#302C25] dark:text-[#F1EBDD] hover:bg-[#354638] hover:text-[#FBF9F2] dark:hover:bg-[#354638] transition-colors">
        ← Kembali ke Galeri
      </a>
      <span class="label-caps text-[#68705C] dark:text-[#B8BDAA]">DETAIL KARYA SENI</span>
    </div>

    {{-- Kontainer Dua Kolom Proporsional (Desktop: Berdampingan | Mobile: Satu Kolom) --}}
    <article class="grid grid-cols-1 lg:grid-cols-12 bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden detail-image-reveal">
      {{-- KOLOM KIRI: Gambar Karya Berukuran Besar Sesuai Proporsi Asli (Tanpa Overlay Warna) --}}
      <div class="lg:col-span-7 bg-[#EAE5D5] dark:bg-[#20291F] p-5 sm:p-8 lg:p-10 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-[#D6D1C2] dark:border-[#3A4637]">
        <div class="flex-1 flex items-center justify-center">
          <img
            data-gambar-karya
            src="{{ $karya->url_foto }}"
            alt="{{ $karya->judul }} oleh {{ $seniman->nama_lengkap }}"
            referrerpolicy="no-referrer"
            class="max-h-[78vh] w-auto max-w-full object-contain block"
          />
          <div data-fallback-gambar class="hidden w-full aspect-[4/5] flex flex-col items-center justify-center bg-[#F4F1E6] dark:bg-[#171D18] p-8 text-center">
            <p class="font-display italic text-2xl text-[#302C25] dark:text-[#F1EBDD]">{{ $karya->judul }}</p>
            <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA]">{{ $seniman->nama_lengkap }}</p>
          </div>
        </div>

        <div class="mt-6 pt-4 border-t border-[#D6D1C2] dark:border-[#3A4637] flex flex-wrap items-center justify-between gap-3">
          <p class="text-xs text-[#68705C] dark:text-[#B8BDAA]">
            Dokumentasi karya — proporsi asli dipertahankan tanpa pemotongan.
          </p>
          <button
            type="button"
            data-pemicu-zoom
            data-zoom-src="{{ $karya->url_foto }}"
            data-zoom-judul="{{ $karya->judul }} — {{ $seniman->nama_lengkap }} ({{ $karya->tahun_pembuatan }})"
            class="px-4 py-2 bg-[#354638] dark:bg-[#D4A943] text-[#FBF9F2] dark:text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#29382D] dark:hover:bg-[#F1EBDD] transition-colors whitespace-nowrap"
          >
            Perbesar Gambar
          </button>
        </div>
      </div>

      {{-- KOLOM KANAN: Informasi Akun Seniman, Judul Editorial, Detail Karya, Harga Opsional, & Kartu Profil Seniman --}}
      <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 flex flex-col justify-between space-y-8">
        <div class="space-y-6">
          {{-- 1. Informasi Akun Seniman --}}
          <div class="flex items-center justify-between gap-4 pb-5 border-b border-[#D6D1C2] dark:border-[#3A4637]">
            <a href="{{ route('seniman.profil', $seniman->slug) }}" class="flex items-center gap-3.5 group min-w-0">
              <img
                src="{{ $seniman->url_foto }}"
                alt="Foto profil {{ $seniman->nama_lengkap }}"
                referrerpolicy="no-referrer"
                class="h-12 w-12 object-cover shrink-0 border border-[#D6D1C2] dark:border-[#3A4637] bg-[#EAE5D5] dark:bg-[#20291F]"
              />
              <div class="min-w-0">
                <p class="label-caps text-[#68705C] dark:text-[#B8BDAA]">SENIMAN</p>
                <p class="font-display text-lg font-semibold text-[#302C25] dark:text-[#F1EBDD] group-hover:text-[#354638] dark:group-hover:text-[#D4A943] truncate transition-colors">
                  {{ $seniman->nama_lengkap }}
                </p>
              </div>
            </a>
            <a href="{{ route('seniman.profil', $seniman->slug) }}" class="px-3.5 py-2 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] hover:bg-[#354638] hover:text-[#FBF9F2] dark:hover:bg-[#A5B18A] dark:hover:text-[#171D18] text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] transition-colors whitespace-nowrap shrink-0">
              Profil
            </a>
          </div>

          {{-- 2. Judul Karya dengan Tipografi Editorial --}}
          <div>
            @if($karya->kategori)
              <span class="inline-block px-2.5 py-1 bg-[#D4A943] text-[#302C25] label-caps rounded-[0.125rem]">
                {{ $karya->kategori->nama }}
              </span>
            @endif
            <h1 class="mt-3 font-display text-3xl sm:text-4xl font-semibold leading-tight text-[#302C25] dark:text-[#F1EBDD] kinetic-heading">
              {{ $karya->judul }}
            </h1>
          </div>

          {{-- 3. Informasi Karya (Deskripsi, Tahun, Media/Bahan, Kategori, Informasi Tambahan) --}}
          <div class="space-y-5">
            <p class="text-base leading-relaxed text-[#302C25] dark:text-[#F1EBDD]">
              {{ $karya->deskripsi }}
            </p>

            <dl class="divide-y divide-[#D6D1C2] dark:divide-[#3A4637] border-y border-[#D6D1C2] dark:border-[#3A4637] text-sm">
              <div class="py-3 grid grid-cols-12 gap-3">
                <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">TAHUN PEMBUATAN</dt>
                <dd class="col-span-7 font-medium text-[#302C25] dark:text-[#F1EBDD] tabular-nums">{{ $karya->tahun_pembuatan }}</dd>
              </div>
              <div class="py-3 grid grid-cols-12 gap-3">
                <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">MEDIA / BAHAN</dt>
                <dd class="col-span-7 text-[#302C25] dark:text-[#F1EBDD] leading-relaxed">{{ $karya->media_bahan }}</dd>
              </div>
              @if($karya->kategori)
                <div class="py-3 grid grid-cols-12 gap-3">
                  <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">KATEGORI</dt>
                  <dd class="col-span-7 text-[#302C25] dark:text-[#F1EBDD]">{{ $karya->kategori->nama }}</dd>
                </div>
              @endif
              @if($karya->dimensi)
                <div class="py-3 grid grid-cols-12 gap-3">
                  <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">DIMENSI</dt>
                  <dd class="col-span-7 text-[#302C25] dark:text-[#F1EBDD] tabular-nums">{{ $karya->dimensi }}</dd>
                </div>
              @endif
              @if($karya->informasi_tambahan)
                <div class="py-3 grid grid-cols-12 gap-3">
                  <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">INFO TAMBAHAN</dt>
                  <dd class="col-span-7 text-[#302C25] dark:text-[#F1EBDD] leading-relaxed">{{ $karya->informasi_tambahan }}</dd>
                </div>
              @endif
            </dl>
          </div>

          {{-- 4. Informasi Harga Opsional (Hanya tampil jika diisi seniman; TANPA tombol pembelian/transaksi) --}}
          @if($karya->harga_terformat)
            <div class="bg-[#EAE5D5] dark:bg-[#20291F] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-4">
              <p class="label-caps text-[#354638] dark:text-[#D4A943]">INFORMASI HARGA (OPSIONAL)</p>
              <p class="mt-1.5 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD] tabular-nums">
                {{ $karya->harga_terformat }}
              </p>
              <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">
                Dicantumkan sebagai informasi referensi oleh seniman. ARTSPACE tidak menyediakan fitur pembelian atau transaksi.
              </p>
            </div>
          @endif
        </div>

        {{-- 5. Kartu Informasi Seniman & Tautan Menuju Profil Lengkap --}}
        <div class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] rounded-[0.25rem] p-5 border border-[#29382D] dark:border-[#3A4637]">
          <p class="label-caps text-[#D4A943]">TENTANG SENIMAN</p>
          <div class="mt-3 flex items-start gap-4">
            <img
              src="{{ $seniman->url_foto }}"
              alt="{{ $seniman->nama_lengkap }}"
              referrerpolicy="no-referrer"
              class="h-14 w-14 object-cover shrink-0 border border-[#D4A943]/50"
            />
            <div class="min-w-0">
              <h2 class="font-display text-lg font-semibold text-[#FBF9F2] dark:text-[#F1EBDD]">{{ $seniman->nama_lengkap }}</h2>
              <p class="text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">{{ $seniman->kota }} · {{ $seniman->disiplin }}</p>
            </div>
          </div>
          <p class="mt-3 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
            {{ $seniman->biografi_singkat }}
          </p>
          <a href="{{ route('seniman.profil', $seniman->slug) }}" class="mt-4 inline-flex items-center justify-center w-full py-2.5 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#FBF9F2] transition-colors">
            Lihat Profil & Riwayat Pameran Seniman
          </a>
        </div>
      </div>
    </article>
  </section>
@endsection
