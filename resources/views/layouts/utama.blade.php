<!doctype html>
<html lang="id" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $judul_halaman ?? 'ARTSPACE — Jelajahi Karya Seni & Profil Seniman' }}</title>
    <meta name="description" content="ARTSPACE adalah platform eksplorasi visual karya seni kontemporer dan portofolio digital seniman Indonesia." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet" />
    <script>
      (function () {
        try {
          var tersimpan = localStorage.getItem('artspace_tema');
          if (tersimpan === 'dark' || (!tersimpan && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
          }
        } catch (e) {}
      })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="min-h-screen flex flex-col bg-[#F4F1E6] text-[#302C25] dark:bg-[#171D18] dark:text-[#F1EBDD] font-sans antialiased transition-colors duration-200 selection:bg-[#D4A943] selection:text-[#302C25]">
    @include('komponen.navigasi')

    @if(session('sukses'))
      <div class="bg-[#D4A943] text-[#302C25] border-b border-[#302C25]" role="status">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-3 flex items-center justify-between gap-4 text-sm font-semibold">
          <span>{{ session('sukses') }}</span>
          <button type="button" data-tutup-notifikasi class="text-xs uppercase tracking-[0.12em] underline underline-offset-4 shrink-0">Tutup</button>
        </div>
      </div>
    @endif

    @if(session('galat'))
      <div class="bg-[#7A271A] text-[#FBF9F2] border-b border-[#302C25]" role="alert">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-3 flex items-center justify-between gap-4 text-sm font-medium">
          <span>{{ session('galat') }}</span>
          <button type="button" data-tutup-notifikasi class="text-xs uppercase tracking-[0.12em] underline underline-offset-4 shrink-0">Tutup</button>
        </div>
      </div>
    @endif

    <main class="flex-1 page-enter">
      @yield('konten')
    </main>

    @include('komponen.footer')

    {{-- Menu Navigasi Mobile --}}
    <div data-drawer-mobile class="hidden fixed inset-0 z-50 bg-[#29382D] dark:bg-[#171D18] text-[#FBF9F2] dark:text-[#F1EBDD] flex flex-col" role="dialog" aria-modal="true" aria-label="Menu Navigasi Seluler">
      <div class="flex items-center justify-between px-5 h-16 border-b border-[#77805B]/40 dark:border-[#3A4637]">
        <a href="{{ route('beranda') }}" class="font-display text-2xl font-semibold tracking-[0.06em] text-[#FBF9F2]">ARTSPACE</a>
        <button type="button" data-tutup-mobile class="px-3.5 py-2 text-xs font-semibold uppercase tracking-[0.12em] border border-[#D4A943] text-[#D4A943] rounded-[0.25rem]">
          Tutup
        </button>
      </div>

      <div class="p-5 border-b border-[#77805B]/30 dark:border-[#3A4637]">
        <form method="GET" action="{{ route('beranda') }}" class="flex gap-2">
          <input
            type="search"
            name="cari"
            value="{{ request('cari', '') }}"
            placeholder="Cari judul karya atau seniman..."
            class="flex-1 bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm"
          />
          <button type="submit" class="px-4 py-2.5 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
            Cari
          </button>
        </form>
      </div>

      <nav class="flex-1 px-6 py-8 flex flex-col gap-5">
        <a href="{{ route('beranda') }}" class="font-display text-3xl text-[#FBF9F2] hover:text-[#D4A943]">Beranda</a>
        <a href="{{ route('karya.jelajahi') }}" class="font-display text-3xl text-[#FBF9F2] hover:text-[#D4A943]">Jelajahi Karya</a>
        <a href="{{ route('seniman.daftar') }}" class="font-display text-3xl text-[#FBF9F2] hover:text-[#D4A943]">Seniman</a>
        @auth
          @if(auth()->user()->adalahAdmin())
            <a href="{{ route('dasbor.admin') }}" class="font-display text-3xl text-[#D4A943]">Dasbor Admin</a>
          @else
            <a href="{{ route('dasbor.seniman') }}" class="font-display text-3xl text-[#D4A943]">Dasbor Seniman</a>
          @endif
        @endauth
      </nav>

      <div class="p-6 border-t border-[#77805B]/40 dark:border-[#3A4637] space-y-3">
        <button type="button" data-sakelar-tema class="w-full py-2.5 text-xs font-semibold uppercase tracking-[0.12em] border border-[#D6D1C2]/50 text-[#FBF9F2] rounded-[0.25rem]">
          Ganti Tema Gelap / Terang
        </button>
        @auth
          <form method="POST" action="{{ route('keluar') }}">
            @csrf
            <button type="submit" class="w-full py-3 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.12em] rounded-[0.25rem]">
              Keluar ({{ auth()->user()->nama }})
            </button>
          </form>
        @else
          <a href="{{ route('masuk') }}" class="block text-center w-full py-3 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.12em] rounded-[0.25rem]">
            Masuk / Daftar Seniman
          </a>
        @endauth
      </div>
    </div>

    {{-- Modal Perbesaran Gambar Opsional (khusus tombol Perbesar di halaman detail) --}}
    <div data-modal-zoom class="hidden fixed inset-0 z-50 flex items-center justify-center bg-[#171D18]/95 p-4 md:p-8" role="dialog" aria-modal="true" aria-label="Tampilan Gambar Penuh">
      <div data-tutup-zoom class="fixed inset-0"></div>
      <div class="relative z-10 max-w-6xl max-h-full flex flex-col bg-[#FBF9F2] dark:bg-[#20291F] border border-[#3A4637] p-4">
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-[#D6D1C2] dark:border-[#3A4637]">
          <p data-judul-zoom class="font-display italic text-base text-[#302C25] dark:text-[#F1EBDD]"></p>
          <button type="button" data-tutup-zoom class="px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.1em] bg-[#354638] text-[#FBF9F2] rounded-[0.25rem] hover:bg-[#29382D]">
            Tutup (Esc)
          </button>
        </div>
        <div class="flex items-center justify-center overflow-auto bg-[#EAE5D5] dark:bg-[#171D18] p-2">
          <img data-gambar-zoom src="" alt="" referrerpolicy="no-referrer" class="max-h-[78vh] w-auto object-contain" />
        </div>
      </div>
    </div>
  </body>
</html>
