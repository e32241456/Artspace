<footer class="bg-[#29382D] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-t-2 border-[#D4A943] mt-16">
  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-14">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-10 border-b border-[#77805B]/40 dark:border-[#3A4637]">
      <div class="md:col-span-5">
        <a href="{{ route('beranda') }}" class="font-display text-3xl font-semibold tracking-[0.08em] text-[#FBF9F2] dark:text-[#F1EBDD]">
          ARTSPACE
        </a>
        <div class="mt-4 h-[2px] w-16 bg-[#D4A943]"></div>
        <p class="mt-4 max-w-md text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
          Platform eksplorasi visual karya seni kontemporer dan portofolio digital seniman. Dirancang untuk menemukan karya, mengenal perupa, dan mendokumentasikan perjalanan berkesenian tanpa distraksi komersial.
        </p>
      </div>

      <div class="md:col-span-3">
        <p class="label-caps text-[#D4A943]">EKSPLORASI</p>
        <ul class="mt-4 space-y-2.5 text-sm text-[#EAE5D5] dark:text-[#B8BDAA]">
          <li><a href="{{ route('beranda') }}" class="hover:text-[#D4A943] transition-colors">Beranda Karya</a></li>
          <li><a href="{{ route('karya.jelajahi') }}" class="hover:text-[#D4A943] transition-colors">Jelajahi Karya</a></li>
          <li><a href="{{ route('seniman.daftar') }}" class="hover:text-[#D4A943] transition-colors">Temukan Seniman</a></li>
        </ul>
      </div>

      <div class="md:col-span-4">
        <p class="label-caps text-[#D4A943]">UNTUK SENIMAN</p>
        <p class="mt-4 text-sm text-[#EAE5D5] dark:text-[#B8BDAA] leading-relaxed">
          Bangun portofolio digital, publikasikan karya seni langsung ke katalog terbuka, dan arsipkan riwayat pameran Anda di satu ruang kurasi.
        </p>
        <div class="mt-5 flex flex-wrap gap-3">
          <a href="{{ route('daftar') }}" class="px-4 py-2 bg-[#D4A943] text-[#302C25] text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] hover:bg-[#FBF9F2] transition-colors">
            Daftar Seniman
          </a>
          <a href="{{ route('masuk') }}" class="px-4 py-2 border border-[#D4A943] text-[#D4A943] text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] hover:bg-[#D4A943] hover:text-[#302C25] transition-colors">
            Masuk Akun
          </a>
        </div>
      </div>
    </div>

    <div class="pt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">
      <p>&copy; {{ date('Y') }} ARTSPACE. Platform Eksplorasi Karya Seni & Portofolio Seniman.</p>
      <p>Hak cipta setiap karya sepenuhnya milik seniman masing-masing.</p>
    </div>
  </div>
</footer>
