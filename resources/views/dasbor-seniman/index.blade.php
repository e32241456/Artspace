@extends('layouts.utama')

@section('konten')
  {{-- Tajuk Dasbor Seniman (Forest Olive & Mustard) --}}
  <section class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex items-center gap-5">
          <img
            src="{{ $seniman->url_foto }}"
            alt="{{ $seniman->nama_lengkap }}"
            referrerpolicy="no-referrer"
            class="h-16 w-16 object-cover border-2 border-[#D4A943] shrink-0"
          />
          <div>
            <p class="label-caps text-[#D4A943]">DASBOR SENIMAN</p>
            <h1 class="mt-1 font-display text-3xl sm:text-4xl font-semibold">{{ $seniman->nama_lengkap }}</h1>
            <p class="mt-1 text-xs text-[#EAE5D5] dark:text-[#B8BDAA]">{{ $seniman->kota }} · {{ $seniman->disiplin }}</p>
          </div>
        </div>

        <a href="{{ route('seniman.profil', $seniman->slug) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#D4A943] text-[#302C25] hover:bg-[#FBF9F2] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem] transition-colors whitespace-nowrap self-start md:self-end">
          Lihat Profil Publik Saya →
        </a>
      </div>

      {{-- A. Ringkasan Dasbor Seniman --}}
      <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-[#29382D] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">KARYA TERBIT</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">{{ $daftar_karya->count() }}</p>
          <p class="mt-1 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">Karya langsung terbit di katalog publik</p>
        </div>
        <div class="bg-[#29382D] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">RIWAYAT PAMERAN</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">{{ $riwayat_pameran->count() }}</p>
          <p class="mt-1 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">Tampil terpadu di halaman profil Anda</p>
        </div>
        <div class="bg-[#29382D] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">KELENGKAPAN PROFIL</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">{{ $kelengkapan_profil }}%</p>
          <div class="mt-2 h-1.5 w-full bg-[#171D18] overflow-hidden">
            <div class="h-full bg-[#D4A943]" style="width: {{ $kelengkapan_profil }}%"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Navigasi Tab Bagian Dasbor --}}
  <div class="bg-[#EAE5D5] dark:bg-[#20291F] border-b border-[#D6D1C2] dark:border-[#3A4637]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-3 flex flex-wrap gap-2" role="tablist">
      <button type="button" data-tab-dasbor="karya" aria-selected="true" class="px-4 py-2 text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] bg-[#354638] text-[#FBF9F2] dark:bg-[#D4A943] dark:text-[#302C25] border border-[#354638] dark:border-[#D4A943]">
        Kelola Karya Seni
      </button>
      <button type="button" data-tab-dasbor="profil" aria-selected="false" class="px-4 py-2 text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] bg-[#FBF9F2] text-[#302C25] dark:bg-[#293326] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637]">
        Kelola Profil Seniman
      </button>
      <button type="button" data-tab-dasbor="pameran" aria-selected="false" class="px-4 py-2 text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] bg-[#FBF9F2] text-[#302C25] dark:bg-[#293326] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637]">
        Kelola Riwayat Pameran
      </button>
    </div>
  </div>

  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10 space-y-10">
    @if($errors->any())
      <div class="bg-[#7A271A]/10 dark:bg-[#7A271A]/30 border border-[#BA1A1A] text-[#7A271A] dark:text-[#FFDAD6] rounded-[0.25rem] p-4" role="alert">
        <p class="label-caps mb-2">PERIKSA KEMBALI ISIAN FORMULIR</p>
        <ul class="text-sm space-y-1">
          @foreach($errors->all() as $err)
            <li>— {{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- B. PENGELOLAAN KARYA SENI --}}
    <section data-panel-dasbor="karya" class="space-y-10">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {{-- Form Tambah Karya Baru --}}
        <div class="lg:col-span-5 bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6 lg:p-8">
          <p class="label-caps text-[#354638] dark:text-[#D4A943]">TERBITKAN KARYA BARU</p>
          <h2 class="mt-2 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Tambah Karya Seni</h2>
          <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">
            Karya yang Anda tambahkan akan langsung berstatus <strong>TERBIT</strong> pada katalog publik.
          </p>

          <form method="POST" action="{{ route('dasbor.seniman.karya.simpan') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
            @csrf

            <div>
              <label for="judul" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">JUDUL KARYA *</label>
              <input id="judul" name="judul" type="text" required value="{{ old('judul') }}" placeholder="Contoh: Monolog Tanah Basah II" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label for="kategori_id" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">KATEGORI</label>
                <select id="kategori_id" name="kategori_id" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2.5 text-sm">
                  @foreach($daftar_kategori as $kat)
                    <option value="{{ $kat->id }}" {{ (string) old('kategori_id') === (string) $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label for="tahun_pembuatan" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">TAHUN *</label>
                <input id="tahun_pembuatan" name="tahun_pembuatan" type="number" required min="1900" max="2030" value="{{ old('tahun_pembuatan', date('Y')) }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm tabular-nums" />
              </div>
            </div>

            <div>
              <label for="media_bahan" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">MEDIA / BAHAN *</label>
              <input id="media_bahan" name="media_bahan" type="text" required value="{{ old('media_bahan') }}" placeholder="Cat minyak & pigmen tanah di atas linen" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label for="dimensi" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">DIMENSI</label>
                <input id="dimensi" name="dimensi" type="text" value="{{ old('dimensi') }}" placeholder="120 × 90 cm" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
              </div>
              <div>
                <label for="harga_opsional" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">HARGA OPSIONAL (RP)</label>
            <input
                id="harga_opsional"
                name="harga_opsional"
                type="text"
                inputmode="numeric"
                data-format-rupiah
                value="{{ old('harga_opsional') !== null ? (int) old('harga_opsional') : '' }}"
                placeholder="Kosongkan jika tidak diisi"
                class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm tabular-nums"
            />              </div>
            </div>

            <div>
              <label for="deskripsi" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">DESKRIPSI KARYA *</label>
              <textarea id="deskripsi" name="deskripsi" rows="3" required placeholder="Ceritakan gagasan, proses, dan konteks karya..." class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
              <label for="informasi_tambahan" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">INFORMASI TAMBAHAN</label>
              <input id="informasi_tambahan" name="informasi_tambahan" type="text" value="{{ old('informasi_tambahan') }}" placeholder="Catatan seri, edisi, atau keterangan konservasi" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
            </div>

            <div>
              <label for="foto_karya" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">UNGGAH FOTO KARYA (JPG, PNG, WEBP — MAKS. 5 MB) *</label>
              <input id="foto_karya" name="foto_karya" type="file" required accept="image/jpeg,image/png,image/webp" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-xs" />
            </div>

            <button type="submit" class="w-full py-3 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
              Terbitkan Karya Sekarang
            </button>
          </form>
        </div>

        {{-- Daftar Karya Milik Seniman --}}
        <div class="lg:col-span-7 space-y-5">
          <div class="flex items-center justify-between gap-4 pb-3 border-b border-[#D6D1C2] dark:border-[#3A4637]">
            <h2 class="font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Daftar Karya Saya</h2>
            <span class="text-xs font-semibold text-[#68705C] dark:text-[#B8BDAA] tabular-nums">{{ $daftar_karya->count() }} Karya</span>
          </div>

          @forelse($daftar_karya as $karya)
            <article class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-5">
              <div class="flex flex-col sm:flex-row gap-5">
                <img src="{{ $karya->url_foto }}" alt="{{ $karya->judul }}" referrerpolicy="no-referrer" class="w-full sm:w-28 h-36 object-cover bg-[#EAE5D5] dark:bg-[#20291F] shrink-0" />
                <div class="flex-1 min-w-0">
                  <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.12em] rounded-[0.125rem] {{ $karya->status === 'TERBIT' ? 'bg-[#354638] text-[#FBF9F2] dark:bg-[#A5B18A] dark:text-[#171D18]' : 'bg-[#7A271A] text-[#FBF9F2]' }}">
                      {{ $karya->status }}
                    </span>
                    <span class="text-xs text-[#68705C] dark:text-[#B8BDAA] tabular-nums">{{ $karya->tahun_pembuatan }} · {{ $karya->kategori?->nama ?? 'Umum' }}</span>
                  </div>
                  <h3 class="mt-2 font-display text-xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">
                    <a href="{{ route('karya.detail', $karya->slug) }}" class="hover:underline">{{ $karya->judul }}</a>
                  </h3>
                  <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">{{ $karya->media_bahan }}</p>
                  <p class="mt-2 text-sm text-[#302C25] dark:text-[#F1EBDD]/90 line-clamp-2">{{ $karya->deskripsi }}</p>

                  <div class="mt-4 flex flex-wrap items-center gap-2.5">
                    <button type="button" data-buka-edit="edit-karya-{{ $karya->id }}" class="px-3.5 py-1.5 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] text-xs font-semibold rounded-[0.25rem] hover:bg-[#354638] hover:text-[#FBF9F2]">
                      Ubah Karya
                    </button>
                    <form method="POST" action="{{ route('dasbor.seniman.karya.hapus', $karya) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="px-3.5 py-1.5 border border-[#BA1A1A] text-[#BA1A1A] dark:text-[#FFDAD6] text-xs font-semibold rounded-[0.25rem] hover:bg-[#BA1A1A] hover:text-[#FBF9F2]">
                        Hapus
                      </button>
                    </form>
                  </div>
                </div>
              </div>

              {{-- Formulir Ubah Karya Inline --}}
              <form id="edit-karya-{{ $karya->id }}" method="POST" action="{{ route('dasbor.seniman.karya.perbarui', $karya) }}" enctype="multipart/form-data" class="hidden mt-5 pt-5 border-t border-[#D6D1C2] dark:border-[#3A4637] grid grid-cols-1 sm:grid-cols-2 gap-3">
                @csrf
                @method('PUT')
                <div class="sm:col-span-2">
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">JUDUL *</label>
                  <input name="judul" type="text" required value="{{ $karya->judul }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm" />
                </div>
                <div>
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">KATEGORI</label>
                  <select name="kategori_id" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm">
                    @foreach($daftar_kategori as $kat)
                      <option value="{{ $kat->id }}" {{ $karya->kategori_id === $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div>
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">TAHUN *</label>
                  <input name="tahun_pembuatan" type="number" required value="{{ $karya->tahun_pembuatan }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm tabular-nums" />
                </div>
                <div class="sm:col-span-2">
<input
    name="media_bahan"
    type="text"
    required
    value="{{ $karya->media_bahan }}"
    class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm"
/>              <input
                  name="harga_opsional"
                  type="text"
                  inputmode="numeric"
                  data-format-rupiah
                  value="{{ $karya->harga_opsional !== null ? (int) $karya->harga_opsional : '' }}"
                  class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm tabular-nums"
/>                </div>
                <div>
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">DIMENSI</label>
                  <input name="dimensi" type="text" value="{{ $karya->dimensi ?? '' }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm" />
                </div>
                <div>
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">HARGA OPSIONAL (RP)</label>
                  <input name="harga_opsional" type="number" min="0" value="{{ $karya->harga_opsional ?? '' }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm tabular-nums" />
                </div>
                <div class="sm:col-span-2">
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">DESKRIPSI *</label>
                  <textarea name="deskripsi" rows="2" required class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm">{{ $karya->deskripsi }}</textarea>
                </div>
                <div class="sm:col-span-2">
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">INFORMASI TAMBAHAN</label>
                  <input name="informasi_tambahan" type="text" value="{{ $karya->informasi_tambahan ?? '' }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm" />
                </div>
                <div>
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">GANTI FOTO KARYA (OPSIONAL)</label>
                  <input name="foto_karya" type="file" accept="image/jpeg,image/png,image/webp" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-2.5 py-1.5 text-xs" />
                </div>
                <div class="flex items-end">
                  <button type="submit" class="w-full py-2 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
                    Simpan Perubahan
                  </button>
                </div>
              </form>
            </article>
          @empty
            <div class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-8 text-center">
              <p class="font-display text-lg text-[#302C25] dark:text-[#F1EBDD]">Belum ada karya terdaftar.</p>
              <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">Gunakan formulir di samping untuk menerbitkan karya pertama Anda.</p>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    {{-- C. PENGELOLAAN PROFIL SENIMAN --}}
    <section data-panel-dasbor="profil" class="hidden">
      <div class="max-w-4xl bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6 lg:p-10">
        <p class="label-caps text-[#354638] dark:text-[#D4A943]">IDENTITAS PORTOFOLIO</p>
        <h2 class="mt-2 font-display text-2xl sm:text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Kelola Profil Seniman</h2>

        <form method="POST" action="{{ route('dasbor.seniman.profil') }}" enctype="multipart/form-data" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
          @csrf
          @method('PUT')
          <div>
            <label for="profil_nama" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">NAMA LENGKAP *</label>
            <input id="profil_nama" name="nama_lengkap" type="text" required value="{{ old('nama_lengkap', $seniman->nama_lengkap) }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
          </div>
          <div>
            <label for="profil_kota" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">KOTA *</label>
            <input id="profil_kota" name="kota" type="text" required value="{{ old('kota', $seniman->kota) }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
          </div>
          <div class="md:col-span-2">
            <label for="profil_disiplin" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">DISIPLIN BERKESENIAN *</label>
            <input id="profil_disiplin" name="disiplin" type="text" required value="{{ old('disiplin', $seniman->disiplin) }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
          </div>
          <div class="md:col-span-2">
            <label for="profil_foto" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">FOTO PROFIL SENIMAN (JPG, PNG, WEBP — MAKS. 4 MB)</label>
            <input id="profil_foto" name="foto_profil" type="file" accept="image/jpeg,image/png,image/webp" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-xs" />
          </div>
          <div class="md:col-span-2">
            <label for="profil_bio_singkat" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">BIOGRAFI SINGKAT *</label>
            <textarea id="profil_bio_singkat" name="biografi_singkat" rows="2" required class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">{{ old('biografi_singkat', $seniman->biografi_singkat) }}</textarea>
          </div>
          <div class="md:col-span-2">
            <label for="profil_bio" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">BIOGRAFI LENGKAP *</label>
            <textarea id="profil_bio" name="biografi" rows="3" required class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">{{ old('biografi', $seniman->biografi) }}</textarea>
          </div>
          <div class="md:col-span-2">
            <label for="profil_latar" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">LATAR BELAKANG</label>
            <textarea id="profil_latar" name="latar_belakang" rows="2" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">{{ old('latar_belakang', $seniman->latar_belakang) }}</textarea>
          </div>
          <div class="md:col-span-2">
            <label for="profil_perjalanan" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">PERJALANAN BERKESENIAN</label>
            <textarea id="profil_perjalanan" name="perjalanan_berkesenian" rows="2" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">{{ old('perjalanan_berkesenian', $seniman->perjalanan_berkesenian) }}</textarea>
          </div>
          <div class="md:col-span-2">
            <label for="profil_pengalaman" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">PENGALAMAN</label>
            <textarea id="profil_pengalaman" name="pengalaman" rows="2" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">{{ old('pengalaman', $seniman->pengalaman) }}</textarea>
          </div>
          <div class="md:col-span-2 flex justify-end pt-3">
            <button type="submit" class="px-7 py-3 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
              Simpan Perubahan Profil
            </button>
          </div>
        </form>
      </div>
    </section>

    {{-- D. PENGELOLAAN RIWAYAT PAMERAN --}}
    <section data-panel-dasbor="pameran" class="hidden">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-5 bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6 lg:p-8">
          <p class="label-caps text-[#354638] dark:text-[#D4A943]">ARSIP PROFIL SENIMAN</p>
          <h2 class="mt-2 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Tambah Riwayat Pameran</h2>

          <form method="POST" action="{{ route('dasbor.seniman.pameran.simpan') }}" class="mt-6 space-y-4">
            @csrf
            <div>
              <label for="nama_pameran" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">NAMA PAMERAN *</label>
              <input id="nama_pameran" name="nama_pameran" type="text" required placeholder="Contoh: Biennale Seni Rupa Nusantara" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
            </div>
            <div class="grid grid-cols-3 gap-3">
              <div class="col-span-2">
                <label for="lokasi_pameran" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">LOKASI *</label>
                <input id="lokasi_pameran" name="lokasi" type="text" required placeholder="Museum / Galeri, Kota" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
              </div>
              <div>
                <label for="tahun_pameran" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">TAHUN *</label>
                <input id="tahun_pameran" name="tahun" type="number" required min="1950" max="2030" value="{{ date('Y') }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm tabular-nums" />
              </div>
            </div>
            <div>
              <label for="deskripsi_pameran" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">DESKRIPSI</label>
              <textarea id="deskripsi_pameran" name="deskripsi" rows="3" placeholder="Ringkasan partisipasi atau tema pameran..." class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm"></textarea>
            </div>
            <button type="submit" class="w-full py-3 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
              Tambahkan ke Profil
            </button>
          </form>
        </div>

        <div class="lg:col-span-7 space-y-4">
          <h2 class="font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD] pb-3 border-b border-[#D6D1C2] dark:border-[#3A4637]">
            Riwayat Pameran Tercatat
          </h2>

          @forelse($riwayat_pameran as $pameran)
            <article class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-5">
              <div class="flex flex-col items-start gap-4">
              <div class="w-full min-w-0">
                  <span class="px-2 py-0.5 bg-[#D4A943] text-[#302C25] text-xs font-bold tabular-nums rounded-[0.125rem]">
                      {{ $pameran->tahun }}
                  </span>

                  <h3 class="mt-2 font-display text-xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">
                      {{ $pameran->nama_pameran }}
                  </h3>

                  <p class="text-xs text-[#68705C] dark:text-[#B8BDAA]">
                      {{ $pameran->lokasi }}
                  </p>

                  @if($pameran->deskripsi)
                      <p class="mt-2 text-sm text-[#302C25] dark:text-[#F1EBDD]/90">
                          {{ $pameran->deskripsi }}
                      </p>
                  @endif
              </div>

              <div class="flex items-center gap-2">
                  <button
                      type="button"
                      data-buka-edit="edit-pameran-{{ $pameran->id }}"
                      class="px-3 py-1.5 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] text-xs font-semibold rounded-[0.25rem] hover:bg-[#354638] hover:text-[#FBF9F2]">
                      Ubah
                  </button>

                  <form method="POST" action="{{ route('dasbor.seniman.pameran.hapus', $pameran) }}">
                      @csrf
                      @method('DELETE')

                      <button
                          type="submit"
                          class="px-3 py-1.5 border border-[#BA1A1A] text-[#BA1A1A] dark:text-[#FFDAD6] text-xs font-semibold rounded-[0.25rem] hover:bg-[#BA1A1A] hover:text-[#FBF9F2]">
                          Hapus
                      </button>
                  </form>
              </div>
          </div>

              {{-- Formulir Ubah Riwayat Pameran Inline --}}
              <form id="edit-pameran-{{ $pameran->id }}" method="POST" action="{{ route('dasbor.seniman.pameran.perbarui', $pameran) }}" class="hidden mt-4 pt-4 border-t border-[#D6D1C2] dark:border-[#3A4637] grid grid-cols-1 sm:grid-cols-3 gap-3">
                @csrf
                @method('PUT')
                <div class="sm:col-span-3">
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">NAMA PAMERAN *</label>
                  <input name="nama_pameran" type="text" required value="{{ $pameran->nama_pameran }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm" />
                </div>
                <div class="sm:col-span-2">
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">LOKASI *</label>
                  <input name="lokasi" type="text" required value="{{ $pameran->lokasi }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm" />
                </div>
                <div>
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">TAHUN *</label>
                  <input name="tahun" type="number" required min="1950" max="2030" value="{{ $pameran->tahun }}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm tabular-nums" />
                </div>
                <div class="sm:col-span-3">
                  <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">DESKRIPSI</label>
                  <textarea name="deskripsi" rows="2" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm">{{ $pameran->deskripsi }}</textarea>
                </div>
                <div class="sm:col-span-3 flex justify-end">
                  <button type="submit" class="px-5 py-2 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
                    Simpan Perubahan Pameran
                  </button>
                </div>
              </form>
            </article>
          @empty
            <p class="text-sm text-[#68705C] dark:text-[#B8BDAA]">Belum ada riwayat pameran yang dicatat.</p>
          @endforelse
        </div>
      </div>
    </section>
  </div>
@endsection
