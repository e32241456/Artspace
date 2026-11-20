@extends('layouts.utama')

@section('konten')
  <section class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10">
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
          <p class="label-caps text-[#D4A943]">KATALOG PUBLIK TERBIT</p>
          <h1 class="mt-2 font-display text-3xl sm:text-4xl font-semibold kinetic-heading">Jelajahi Karya Seni</h1>
          <p class="mt-2 max-w-2xl text-sm text-[#EAE5D5] dark:text-[#B8BDAA]">
            Seluruh karya yang diterbitkan seniman tampil secara terbuka. Klik karya mana saja untuk membaca deskripsi, media, tahun pembuatan, dan profil senimannya.
          </p>
        </div>

        <form method="GET" action="{{ route('karya.jelajahi') }}" class="flex flex-col sm:flex-row gap-2.5 w-full lg:w-auto">
          <input
            type="search"
            name="cari"
            value="{{ $kata_kunci }}"
            placeholder="Cari judul karya atau seniman..."
            class="sm:w-64 bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm"
          />
          <select name="kategori" class="bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">
            <option value="semua" {{ $kategori_aktif === 'semua' ? 'selected' : '' }}>Semua Kategori</option>
            @foreach($daftar_kategori as $kat)
              <option value="{{ $kat->slug }}" {{ $kategori_aktif === $kat->slug ? 'selected' : '' }}>{{ $kat->nama }}</option>
            @endforeach
          </select>
          <button type="submit" class="px-5 py-2.5 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#FBF9F2] transition-colors whitespace-nowrap">
            Terapkan
          </button>
        </form>
      </div>
    </div>
  </section>

  <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-[#D6D1C2] dark:border-[#3A4637]">
      <p class="text-sm text-[#68705C] dark:text-[#B8BDAA] tabular-nums">
        Menampilkan <strong class="text-[#302C25] dark:text-[#F1EBDD]">{{ $daftar_karya->count() }}</strong> karya terbit
      </p>
      @if($kata_kunci || $kategori_aktif !== 'semua')
        <a href="{{ route('karya.jelajahi') }}" class="text-xs font-semibold uppercase tracking-[0.1em] text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
          Atur Ulang Filter
        </a>
      @endif
    </div>

    @forelse($daftar_karya as $karya)
      @if($loop->first)
        <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-5">
      @endif

      @include('komponen.kartu-karya', ['karya' => $karya])

      @if($loop->last)
        </div>
      @endif
    @empty
      <div class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-12 text-center">
        <h2 class="font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Tidak ada karya ditemukan</h2>
        <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA]">Ubah kata kunci pencarian atau pilih kategori lain.</p>
        <a href="{{ route('karya.jelajahi') }}" class="mt-6 inline-flex px-6 py-2.5 bg-[#D4A943] text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem]">
          Lihat Semua Karya
        </a>
      </div>
    @endforelse
  </section>
@endsection
