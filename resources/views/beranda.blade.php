@extends('layouts.utama')

@section('konten')
  {{-- Bilah Penemuan Ringkas (Fokus Langsung ke Feed Karya Masonry Pinterest — Tanpa Hero Banner Raksasa) --}}
  <section class="bg-[#EAE5D5] dark:bg-[#20291F] border-b border-[#D6D1C2] dark:border-[#3A4637]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-6">
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5">
        <div>
          <div class="flex items-center gap-3">
            <span class="inline-block h-[2px] w-8 bg-[#D4A943]"></span>
            <p class="label-caps text-[#354638] dark:text-[#A5B18A]">EKSPLORASI VISUAL KARYA SENI</p>
          </div>
          <h1 class="mt-2 font-display text-3xl sm:text-4xl font-semibold tracking-tight text-[#302C25] dark:text-[#F1EBDD] kinetic-heading">
            @if($kata_kunci)
              Hasil Pencarian: “{{ $kata_kunci }}”
            @else
              Temukan Karya & Perupa Kontemporer
            @endif
          </h1>
        </div>

        {{-- Kolom Pencarian Mobile & Tablet --}}
        <form method="GET" action="{{ route('beranda') }}" class="flex lg:hidden w-full sm:max-w-md gap-2">
          <input
            type="search"
            name="cari"
            value="{{ $kata_kunci }}"
            placeholder="Cari judul karya atau nama seniman..."
            class="flex-1 bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
          />
          <button type="submit" class="px-4 py-2 bg-[#354638] dark:bg-[#D4A943] text-[#FBF9F2] dark:text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem]">
            Cari
          </button>
        </form>

        {{-- Filter Kategori Dinamis (Masonry Filter) --}}
        <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Saring kategori karya">
          <button
            type="button"
            data-filter-masonry="semua"
            aria-pressed="{{ $kategori_aktif === 'semua' ? 'true' : 'false' }}"
            class="px-3.5 py-2 text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] border transition-colors whitespace-nowrap shrink-0 {{ $kategori_aktif === 'semua' ? 'bg-[#354638] text-[#FBF9F2] border-[#354638] dark:bg-[#D4A943] dark:text-[#302C25] dark:border-[#D4A943]' : 'bg-[#FBF9F2] text-[#302C25] border-[#D6D1C2] hover:border-[#354638] dark:bg-[#293326] dark:text-[#F1EBDD] dark:border-[#3A4637] dark:hover:border-[#D4A943]' }}"
          >
            Semua Karya
          </button>
          @foreach($daftar_kategori as $kat)
            <button
              type="button"
              data-filter-masonry="{{ $kat->slug }}"
              aria-pressed="{{ $kategori_aktif === $kat->slug ? 'true' : 'false' }}"
              class="px-3.5 py-2 text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] border transition-colors whitespace-nowrap shrink-0 {{ $kategori_aktif === $kat->slug ? 'bg-[#354638] text-[#FBF9F2] border-[#354638] dark:bg-[#D4A943] dark:text-[#302C25] dark:border-[#D4A943]' : 'bg-[#FBF9F2] text-[#302C25] border-[#D6D1C2] hover:border-[#354638] dark:bg-[#293326] dark:text-[#F1EBDD] dark:border-[#3A4637] dark:hover:border-[#D4A943]' }}"
            >
              {{ $kat->nama }}
            </button>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- Hasil Seniman Relevan saat Pencarian Aktif (FR-05) --}}
  @if($kata_kunci && $seniman_cocok->isNotEmpty())
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-8">
      <div class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] rounded-[0.25rem] p-6 border border-[#29382D] dark:border-[#3A4637]">
        <div class="flex items-center justify-between gap-4 mb-5">
          <p class="label-caps text-[#D4A943]">SENIMAN YANG RELEVAN</p>
          <a href="{{ route('seniman.daftar', ['cari' => $kata_kunci]) }}" class="text-xs font-semibold text-[#D4A943] underline underline-offset-4">
            Lihat di Direktori Seniman
          </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          @foreach($seniman_cocok as $sen)
            <a href="{{ route('seniman.profil', $sen->slug) }}" class="flex items-center gap-4 p-3.5 bg-[#29382D] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] hover:border-[#D4A943] transition-colors">
              <img src="{{ $sen->url_foto }}" alt="{{ $sen->nama_lengkap }}" referrerpolicy="no-referrer" class="h-14 w-14 object-cover shrink-0 bg-[#171D18]" />
              <div class="min-w-0">
                <p class="font-display text-base font-semibold text-[#FBF9F2] truncate">{{ $sen->nama_lengkap }}</p>
                <p class="text-xs text-[#D6D1C2] dark:text-[#B8BDAA] truncate">{{ $sen->kota }} · {{ $sen->disiplin }}</p>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- FEED MASONRY ASIMETRIS BERGAYA PINTEREST (Fokus Utama Halaman) --}}
  <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-8" aria-label="Galeri Masonry Karya Seni">
    @if($kata_kunci)
      <div class="mb-6 flex items-center justify-between gap-4 text-sm text-[#68705C] dark:text-[#B8BDAA]">
        <p class="tabular-nums">Menampilkan <strong class="text-[#302C25] dark:text-[#F1EBDD]">{{ $daftar_karya->count() }}</strong> karya yang cocok.</p>
        <a href="{{ route('beranda') }}" class="text-xs font-semibold uppercase tracking-[0.1em] text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
          Hapus Pencarian
        </a>
      </div>
    @endif

    @forelse($daftar_karya as $karya)
      @if($loop->first)
        <div data-masonry-grid class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-5">
      @endif

      @include('komponen.kartu-karya', ['karya' => $karya])

      @if($loop->last)
        </div>
      @endif
    @empty
      <div class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-12 text-center">
        <p class="label-caps text-[#354638] dark:text-[#D4A943]">PENCARIAN KOSONG</p>
        <h2 class="mt-3 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Belum ada karya yang cocok</h2>
        <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA] max-w-md mx-auto">
          Coba gunakan kata kunci judul karya atau nama seniman lain, atau jelajahi seluruh koleksi terbuka ARTSPACE.
        </p>
        <a href="{{ route('beranda') }}" class="mt-6 inline-flex px-6 py-2.5 bg-[#D4A943] text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#354638] hover:text-[#FBF9F2] transition-colors">
          Tampilkan Semua Karya
        </a>
      </div>
    @endforelse

    <div data-masonry-kosong class="hidden bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-10 text-center">
      <p class="font-display text-xl text-[#302C25] dark:text-[#F1EBDD]">Belum ada karya dalam kategori ini.</p>
      <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA]">Pilih kategori lain untuk melanjutkan eksplorasi visual.</p>
    </div>

    {{-- Pita Editorial Ringkas Menuju Direktori Seniman (Identitas Olive & Mustard) --}}
    <div class="mt-14 bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-2 border-[#29382D] dark:border-[#3A4637] rounded-[0.25rem] p-8 md:p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
      <div class="max-w-2xl">
        <p class="label-caps text-[#D4A943]">PORTOFOLIO & RIWAYAT PAMERAN</p>
        <h2 class="mt-2 font-display text-2xl sm:text-3xl font-medium">Kenali Latar Belakang & Perjalanan Seniman di Balik Setiap Karya</h2>
        <p class="mt-2 text-sm text-[#EAE5D5] dark:text-[#B8BDAA] tabular-nums">
          {{ $total_seniman }} seniman tergabung · {{ $total_karya }} karya terpublikasi terbuka untuk dieksplorasi tanpa login.
        </p>
      </div>
      <div class="flex flex-wrap gap-3 shrink-0">
        <a href="{{ route('seniman.daftar') }}" class="px-6 py-3 bg-[#D4A943] text-[#302C25] text-xs font-bold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#FBF9F2] transition-colors whitespace-nowrap">
          Temukan Seniman
        </a>
        <a href="{{ route('daftar') }}" class="px-6 py-3 border border-[#D4A943] text-[#D4A943] text-xs font-bold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#D4A943] hover:text-[#302C25] transition-colors whitespace-nowrap">
          Gabung sebagai Seniman
        </a>
      </div>
    </div>
  </section>
@endsection
