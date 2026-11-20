@extends('layouts.utama')

@section('konten')
  {{-- Tajuk Portofolio Editorial Seniman (Forest Olive & Mustard) --}}
  <section class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12 lg:py-16">
      <div class="mb-6">
        <a href="{{ route('seniman.daftar') }}" class="text-xs font-semibold uppercase tracking-[0.12em] text-[#D4A943] hover:underline">
          ← Kembali ke Direktori Seniman
        </a>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <div class="lg:col-span-4">
          <div class="bg-[#29382D] dark:bg-[#171D18] border border-[#D4A943]/60 overflow-hidden aspect-[4/5]">
            <img
              data-gambar-karya
              src="{{ $seniman->url_foto }}"
              alt="Foto profil {{ $seniman->nama_lengkap }}"
              referrerpolicy="no-referrer"
              class="h-full w-full object-cover"
            />
            <div data-fallback-gambar class="hidden h-full w-full flex items-center justify-center p-6 text-center">
              <p class="font-display text-2xl text-[#FBF9F2]">{{ $seniman->nama_lengkap }}</p>
            </div>
          </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
          <div>
            <p class="label-caps text-[#D4A943]">PORTOFOLIO EDITORIAL SENIMAN</p>
            <h1 class="mt-2 font-display text-4xl sm:text-5xl font-semibold kinetic-heading">{{ $seniman->nama_lengkap }}</h1>
            <p class="mt-2 text-sm text-[#EAE5D5] dark:text-[#B8BDAA]">
              {{ $seniman->kota }} · {{ $seniman->disiplin }} · <span class="tabular-nums">{{ $daftar_karya->count() }} Karya Terbit</span>
            </p>
            <div class="mt-5 h-[2px] w-16 bg-[#D4A943]"></div>
          </div>

          <p class="text-base lg:text-lg leading-relaxed text-[#FBF9F2] dark:text-[#F1EBDD] max-w-3xl">
            {{ $seniman->biografi }}
          </p>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-4 border-t border-[#77805B]/40 dark:border-[#3A4637]">
            <div class="bg-[#29382D] dark:bg-[#293326] p-5 rounded-[0.25rem] border border-[#77805B]/30 dark:border-[#3A4637]">
              <p class="label-caps text-[#D4A943]">LATAR BELAKANG</p>
              <p class="mt-2.5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
                {{ $seniman->latar_belakang ?: 'Belum dilengkapi oleh seniman.' }}
              </p>
            </div>
            <div class="bg-[#29382D] dark:bg-[#293326] p-5 rounded-[0.25rem] border border-[#77805B]/30 dark:border-[#3A4637]">
              <p class="label-caps text-[#D4A943]">PERJALANAN BERKESENIAN</p>
              <p class="mt-2.5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
                {{ $seniman->perjalanan_berkesenian ?: 'Belum dilengkapi oleh seniman.' }}
              </p>
            </div>
            <div class="bg-[#29382D] dark:bg-[#293326] p-5 rounded-[0.25rem] border border-[#77805B]/30 dark:border-[#3A4637]">
              <p class="label-caps text-[#D4A943]">PENGALAMAN</p>
              <p class="mt-2.5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
                {{ $seniman->pengalaman ?: 'Belum dilengkapi oleh seniman.' }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Riwayat Pameran (Bagian Terpadu dari Profil Seniman sesuai FR-02) --}}
  <section class="bg-[#EAE5D5] dark:bg-[#20291F] border-b border-[#D6D1C2] dark:border-[#3A4637]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
      <div class="flex items-center gap-3 mb-6">
        <span class="h-[2px] w-10 bg-[#D4A943]"></span>
        <h2 class="font-display text-2xl sm:text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Riwayat Pameran</h2>
      </div>

      @forelse($riwayat_pameran as $pameran)
        @if($loop->first)
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @endif

        <article class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6">
          <div class="flex items-center justify-between gap-2">
            <span class="px-2.5 py-0.5 bg-[#D4A943] text-[#302C25] text-xs font-bold tabular-nums rounded-[0.125rem]">
              {{ $pameran->tahun }}
            </span>
            <span class="text-xs text-[#68705C] dark:text-[#B8BDAA] truncate">{{ $pameran->lokasi }}</span>
          </div>
          <h3 class="mt-3 font-display text-xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">
            {{ $pameran->nama_pameran }}
          </h3>
          @if($pameran->deskripsi)
            <p class="mt-2 text-sm leading-relaxed text-[#68705C] dark:text-[#B8BDAA]">
              {{ $pameran->deskripsi }}
            </p>
          @endif
        </article>

        @if($loop->last)
          </div>
        @endif
      @empty
        <p class="text-sm text-[#68705C] dark:text-[#B8BDAA]">Seniman ini belum menambahkan catatan riwayat pameran.</p>
      @endforelse
    </div>
  </section>

  {{-- Galeri Karya Seniman dalam Masonry Grid Bergaya Pinterest --}}
  <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
    <div class="flex items-end justify-between gap-4 pb-6 mb-8 border-b border-[#D6D1C2] dark:border-[#3A4637]">
      <div>
        <p class="label-caps text-[#354638] dark:text-[#A5B18A]">PORTOFOLIO KARYA</p>
        <h2 class="mt-1.5 font-display text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">
          Galeri Karya {{ $seniman->nama_lengkap }}
        </h2>
      </div>
      <span class="text-xs font-semibold text-[#68705C] dark:text-[#B8BDAA] tabular-nums">
        {{ $daftar_karya->count() }} Karya Terbit
      </span>
    </div>

    @forelse($daftar_karya as $karya)
      @if($loop->first)
        <div class="columns-1 sm:columns-2 lg:columns-3 gap-5">
      @endif

      @include('komponen.kartu-karya', ['karya' => $karya])

      @if($loop->last)
        </div>
      @endif
    @empty
      <div class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-10 text-center">
        <p class="font-display text-xl text-[#302C25] dark:text-[#F1EBDD]">Belum ada karya yang dipublikasikan.</p>
      </div>
    @endforelse
  </section>
@endsection
