<article
  data-kartu-karya
  data-kategori="{{ $karya->kategori?->slug ?? 'umum' }}"
  class="masonry-item reveal-on-scroll break-inside-avoid mb-5 bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden group transition-colors duration-200 hover:border-[#354638] dark:hover:border-[#D4A943]"
>
  <a href="{{ route('karya.detail', $karya->slug) }}" class="block focus:outline-none">
    {{-- Gambar Karya: Proporsi Asli Tanpa Overlay Warna --}}
    <div class="relative overflow-hidden bg-[#EAE5D5] dark:bg-[#20291F]">
      <img
        data-gambar-karya
        src="{{ $karya->url_foto }}"
        alt="{{ $karya->judul }} oleh {{ $karya->seniman?->nama_lengkap ?? 'Seniman ARTSPACE' }}"
        loading="lazy"
        referrerpolicy="no-referrer"
        class="w-full h-auto block transition-transform duration-300 ease-out group-hover:scale-[1.03]"
      />
      <div data-fallback-gambar class="hidden aspect-[4/5] flex flex-col items-center justify-center p-6 text-center bg-[#EAE5D5] dark:bg-[#20291F]">
        <p class="font-display italic text-lg text-[#302C25] dark:text-[#F1EBDD]">{{ $karya->judul }}</p>
        <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">{{ $karya->seniman?->nama_lengkap ?? 'Seniman ARTSPACE' }}</p>
      </div>
    </div>

    {{-- Informasi Minimalis Bergaya Pinterest: Hanya Judul Karya & Nama Seniman (Tanpa Harga/Tombol Beli) --}}
    <div class="px-4 py-3.5 bg-[#FBF9F2] dark:bg-[#293326] border-t border-[#D6D1C2]/80 dark:border-[#3A4637] transition-colors duration-200 group-hover:bg-[#EAE5D5] dark:group-hover:bg-[#354638]">
      <h3 class="font-display text-base font-semibold leading-snug text-[#302C25] dark:text-[#F1EBDD] group-hover:text-[#29382D] dark:group-hover:text-[#F1EBDD]">
        {{ $karya->judul }}
      </h3>
      <div class="mt-1 flex items-center justify-between gap-2">
        <p class="text-xs font-medium text-[#68705C] dark:text-[#B8BDAA] truncate">
          {{ $karya->seniman?->nama_lengkap ?? 'Seniman ARTSPACE' }}
        </p>
        <span class="text-[11px] font-semibold text-[#354638] dark:text-[#D4A943] opacity-0 translate-y-1 transition-all duration-200 group-hover:opacity-100 group-hover:translate-y-0 whitespace-nowrap shrink-0">
          Lihat Detail →
        </span>
      </div>
    </div>
  </a>
</article>
