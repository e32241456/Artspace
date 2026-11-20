<header class="sticky top-0 z-40 bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 h-16 flex items-center justify-between gap-4 lg:gap-6">
    {{-- Zona 1: Merek ARTSPACE --}}
    <a href="{{ route('beranda') }}" class="font-display text-2xl font-semibold tracking-[0.08em] text-[#FBF9F2] dark:text-[#F1EBDD] whitespace-nowrap shrink-0 flex items-center gap-2">
      <span>ARTSPACE</span>
    </a>

    {{-- Zona 2: Navigasi Utama --}}
    <nav class="hidden md:flex items-center gap-6 text-sm font-medium" aria-label="Navigasi Utama">
      <a href="{{ route('beranda') }}" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors {{ request()->routeIs('beranda') ? 'border-[#D4A943] text-[#D4A943] font-semibold' : 'border-transparent text-[#FBF9F2]/90 dark:text-[#F1EBDD]/90 hover:text-[#D4A943]' }}">
        Beranda
      </a>
      <a href="{{ route('karya.jelajahi') }}" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors {{ request()->routeIs('karya.*') ? 'border-[#D4A943] text-[#D4A943] font-semibold' : 'border-transparent text-[#FBF9F2]/90 dark:text-[#F1EBDD]/90 hover:text-[#D4A943]' }}">
        Jelajahi Karya
      </a>
      <a href="{{ route('seniman.daftar') }}" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors {{ request()->routeIs('seniman.*') ? 'border-[#D4A943] text-[#D4A943] font-semibold' : 'border-transparent text-[#FBF9F2]/90 dark:text-[#F1EBDD]/90 hover:text-[#D4A943]' }}">
        Seniman
      </a>
      @auth
        @if(auth()->user()->adalahAdmin())
          <a href="{{ route('dasbor.admin') }}" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors {{ request()->routeIs('dasbor.admin*') ? 'border-[#D4A943] text-[#D4A943] font-semibold' : 'border-transparent text-[#D4A943]/90 hover:text-[#D4A943]' }}">
            Dasbor Admin
          </a>
        @else
          <a href="{{ route('dasbor.seniman') }}" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors {{ request()->routeIs('dasbor.seniman*') ? 'border-[#D4A943] text-[#D4A943] font-semibold' : 'border-transparent text-[#D4A943]/90 hover:text-[#D4A943]' }}">
            Dasbor Seniman
          </a>
        @endif
      @endauth
    </nav>

    {{-- Kolom Pencarian Global (FR-05: mudah ditemukan) --}}
    <form method="GET" action="{{ route('beranda') }}" class="hidden lg:flex items-center flex-1 max-w-sm" role="search">
      <label for="cari-navigasi" class="sr-only">Cari karya atau seniman</label>
      <div class="relative w-full flex">
        <input
          id="cari-navigasi"
          type="search"
          name="cari"
          value="{{ request('cari', '') }}"
          placeholder="Cari judul karya atau nama seniman..."
          class="w-full bg-[#29382D] dark:bg-[#171D18] text-[#FBF9F2] dark:text-[#F1EBDD] placeholder-[#D6D1C2]/80 dark:placeholder-[#B8BDAA]/70 border border-[#77805B] dark:border-[#3A4637] rounded-l-[0.25rem] px-3.5 py-2 text-xs focus:outline-none focus:border-[#D4A943]"
        />
        <button type="submit" class="px-3.5 py-2 bg-[#D4A943] text-[#302C25] text-xs font-bold uppercase tracking-[0.08em] rounded-r-[0.25rem] hover:bg-[#FBF9F2] transition-colors whitespace-nowrap shrink-0">
          Cari
        </button>
      </div>
    </form>

    {{-- Zona 3: Sakelar Tema & Aksi Masuk / Keluar --}}
    <div class="flex items-center gap-2.5 shrink-0">
      <button
        type="button"
        data-sakelar-tema
        aria-label="Ubah tema terang atau gelap"
        title="Ubah tema terang atau gelap"
        class="px-3 py-2 text-xs font-semibold border border-[#77805B] dark:border-[#3A4637] bg-[#29382D] dark:bg-[#293326] text-[#FBF9F2] dark:text-[#F1EBDD] hover:border-[#D4A943] rounded-[0.25rem] transition-colors whitespace-nowrap shrink-0"
      >
        <span class="dark:hidden">Mode Gelap</span>
        <span class="hidden dark:inline">Mode Terang</span>
      </button>

      @auth
        <form method="POST" action="{{ route('keluar') }}" class="hidden md:inline-flex">
          @csrf
          <button type="submit" class="px-4 py-2 bg-[#D4A943] text-[#302C25] hover:bg-[#FBF9F2] font-semibold text-xs uppercase tracking-[0.08em] rounded-[0.25rem] transition-colors whitespace-nowrap shrink-0">
            Keluar
          </button>
        </form>
      @else
        <a href="{{ route('masuk') }}" class="hidden md:inline-flex items-center justify-center px-5 py-2 bg-[#D4A943] text-[#302C25] hover:bg-[#FBF9F2] font-semibold text-xs uppercase tracking-[0.08em] rounded-[0.25rem] transition-colors whitespace-nowrap shrink-0">
          Masuk
        </a>
      @endauth

      <button
        type="button"
        data-buka-mobile
        aria-label="Buka menu navigasi"
        class="md:hidden px-3.5 py-2 text-xs font-semibold uppercase tracking-[0.1em] bg-[#D4A943] text-[#302C25] rounded-[0.25rem] whitespace-nowrap shrink-0"
      >
        Menu
      </button>
    </div>
  </div>
</header>
