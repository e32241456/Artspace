@extends('layouts.utama')

@section('konten')
  {{-- Tajuk Forest Olive Direktori Seniman --}}
  <section class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
          <p class="label-caps text-[#D4A943]">DIREKTORI PERUPA ARTSPACE</p>
          <h1 class="mt-2 font-display text-4xl sm:text-5xl font-semibold kinetic-heading">Temukan Seniman</h1>
          <p class="mt-3 max-w-2xl text-sm sm:text-base text-[#EAE5D5] dark:text-[#B8BDAA] leading-relaxed">
            Jelajahi profil seniman, latar belakang praktik studio, riwayat pameran, serta arsip karya seni dari setiap perupa terdaftar.
          </p>
        </div>

        <form method="GET" action="{{ route('seniman.daftar') }}" class="flex w-full lg:w-auto gap-2.5">
          <input
            type="search"
            name="cari"
            value="{{ $kata_kunci }}"
            placeholder="Cari nama seniman, kota, atau disiplin..."
            class="flex-1 lg:w-80 bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-2.5 text-sm focus:outline-none focus:border-[#D4A943]"
          />
          <button type="submit" class="px-5 py-2.5 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#FBF9F2] transition-colors whitespace-nowrap">
            Cari Seniman
          </button>
        </form>
      </div>
    </div>
  </section>

  {{-- Daftar Kartu Seniman --}}
  <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
    @if($kata_kunci)
      <div class="mb-8 flex items-center justify-between gap-4 pb-4 border-b border-[#D6D1C2] dark:border-[#3A4637] text-sm">
        <p class="text-[#68705C] dark:text-[#B8BDAA] tabular-nums">
          Ditemukan <strong class="text-[#302C25] dark:text-[#F1EBDD]">{{ $daftar_seniman->count() }}</strong> seniman untuk “{{ $kata_kunci }}”.
        </p>
        <a href="{{ route('seniman.daftar') }}" class="text-xs font-semibold uppercase tracking-[0.1em] text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
          Tampilkan Semua
        </a>
      </div>
    @endif

    @forelse($daftar_seniman as $seniman)
      @if($loop->first)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
      @endif

      <article class="reveal-on-scroll flex flex-col bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden hover:border-[#354638] dark:hover:border-[#D4A943] transition-colors">
        <a href="{{ route('seniman.profil', $seniman->slug) }}" class="block bg-[#EAE5D5] dark:bg-[#20291F] aspect-[4/3] overflow-hidden group">
          <img
            data-gambar-karya
            src="{{ $seniman->url_foto }}"
            alt="Potret {{ $seniman->nama_lengkap }}"
            loading="lazy"
            referrerpolicy="no-referrer"
            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]"
          />
          <div data-fallback-gambar class="hidden h-full w-full flex items-center justify-center p-6 text-center">
            <p class="font-display text-2xl text-[#302C25] dark:text-[#F1EBDD]">{{ $seniman->nama_lengkap }}</p>
          </div>
        </a>

        <div class="flex flex-1 flex-col p-6">
          <div class="flex items-center justify-between gap-3">
            <p class="label-caps text-[#354638] dark:text-[#A5B18A]">{{ $seniman->kota }}</p>
            <span class="px-2.5 py-0.5 bg-[#EAE5D5] dark:bg-[#20291F] border border-[#D6D1C2] dark:border-[#3A4637] text-xs font-semibold text-[#302C25] dark:text-[#F1EBDD] tabular-nums">
              {{ $seniman->karya_seni_count }} Karya
            </span>
          </div>

          <h2 class="mt-2.5 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">
            <a href="{{ route('seniman.profil', $seniman->slug) }}" class="hover:text-[#354638] dark:hover:text-[#D4A943] transition-colors">
              {{ $seniman->nama_lengkap }}
            </a>
          </h2>
          <p class="mt-1 text-xs font-medium text-[#68705C] dark:text-[#B8BDAA]">{{ $seniman->disiplin }}</p>

          <p class="mt-4 text-sm leading-relaxed text-[#302C25] dark:text-[#F1EBDD]/90 flex-1">
            {{ $seniman->biografi_singkat }}
          </p>

          <div class="mt-6 pt-4 border-t border-[#D6D1C2] dark:border-[#3A4637]">
            <a href="{{ route('seniman.profil', $seniman->slug) }}" class="inline-flex w-full items-center justify-center py-2.5 bg-[#354638] dark:bg-[#D4A943] text-[#FBF9F2] dark:text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#29382D] dark:hover:bg-[#F1EBDD] transition-colors">
              Lihat Profil & Portofolio
            </a>
          </div>
        </div>
      </article>

      @if($loop->last)
        </div>
      @endif
    @empty
      <div class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-12 text-center">
        <h2 class="font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Seniman tidak ditemukan</h2>
        <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA]">Coba cari dengan nama atau kota lain.</p>
      </div>
    @endforelse
  </section>
@endsection
