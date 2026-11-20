@extends('layouts.utama')

@section('konten')
  {{-- Tajuk Dasbor Admin (Forest Olive & Mustard) --}}
  <section class="bg-[#29382D] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10">
      <p class="label-caps text-[#D4A943]">ADMINISTRASI & PEMANTAUAN SISTEM</p>
      <h1 class="mt-2 font-display text-3xl sm:text-4xl font-semibold">Dasbor Admin ARTSPACE</h1>
      <p class="mt-2 text-sm text-[#EAE5D5] dark:text-[#B8BDAA] max-w-2xl">
        Pantau akun pengguna, direktori seniman, seluruh karya seni yang terbit, tangani konten yang melanggar ketentuan, serta tinjau laporan data sistem.
      </p>

      {{-- Ringkasan Data Sistem (Tanpa Data Keuangan/Transaksi) --}}
      <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-[#354638] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">TOTAL PENGGUNA</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">{{ $ringkasan['total_pengguna'] }}</p>
        </div>
        <div class="bg-[#354638] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">SENIMAN TERDAFTAR</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">{{ $ringkasan['total_seniman'] }}</p>
        </div>
        <div class="bg-[#354638] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">KARYA TERBIT</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">{{ $ringkasan['total_karya_terbit'] }}</p>
        </div>
        <div class="bg-[#354638] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">KONTEN DITANGGUHKAN</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">{{ $ringkasan['total_karya_ditangguhkan'] }}</p>
        </div>
      </div>
    </div>
  </section>

  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10 space-y-12">
    {{-- 1. Pemantauan Seluruh Karya & Penanganan Pelanggaran --}}
    <section>
      <div class="pb-4 mb-5 border-b border-[#D6D1C2] dark:border-[#3A4637] flex flex-wrap items-end justify-between gap-3">
        <div>
          <p class="label-caps text-[#354638] dark:text-[#A5B18A]">PEMANTAUAN KONTEN</p>
          <h2 class="mt-1 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Seluruh Karya Seni</h2>
        </div>
        <p class="text-xs text-[#68705C] dark:text-[#B8BDAA]">Karya baru langsung terbit otomatis; Admin menindak konten yang melanggar ketentuan.</p>
      </div>

      <div class="overflow-x-auto bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem]">
        <table class="w-full text-left border-collapse text-sm">
          <thead>
            <tr class="bg-[#EAE5D5] dark:bg-[#20291F] border-b border-[#D6D1C2] dark:border-[#3A4637] text-xs uppercase tracking-[0.1em] text-[#302C25] dark:text-[#F1EBDD]">
              <th class="py-3.5 px-4">Karya</th>
              <th class="py-3.5 px-4">Seniman</th>
              <th class="py-3.5 px-4">Kategori</th>
              <th class="py-3.5 px-4">Tahun</th>
              <th class="py-3.5 px-4">Status</th>
              <th class="py-3.5 px-4 text-right">Tindakan Moderasi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-[#D6D1C2] dark:divide-[#3A4637]">
            @foreach($daftar_karya as $karya)
              <tr class="hover:bg-[#F4F1E6] dark:hover:bg-[#20291F]/60">
                <td class="py-3.5 px-4">
                  <div class="flex items-center gap-3">
                    <img src="{{ $karya->url_foto }}" alt="{{ $karya->judul }}" referrerpolicy="no-referrer" class="h-11 w-11 object-cover bg-[#EAE5D5] shrink-0" />
                    <div>
                      <a href="{{ route('karya.detail', $karya->slug) }}" class="font-display font-semibold text-[#302C25] dark:text-[#F1EBDD] hover:underline">{{ $karya->judul }}</a>
                      @if($karya->catatan_moderasi)
                        <p class="text-xs text-[#BA1A1A] dark:text-[#FFDAD6] mt-0.5">{{ $karya->catatan_moderasi }}</p>
                      @endif
                    </div>
                  </div>
                </td>
                <td class="py-3.5 px-4 text-[#302C25] dark:text-[#F1EBDD]">{{ $karya->seniman?->nama_lengkap ?? '-' }}</td>
                <td class="py-3.5 px-4 text-[#68705C] dark:text-[#B8BDAA]">{{ $karya->kategori?->nama ?? 'Umum' }}</td>
                <td class="py-3.5 px-4 tabular-nums text-[#68705C] dark:text-[#B8BDAA]">{{ $karya->tahun_pembuatan }}</td>
                <td class="py-3.5 px-4">
                  <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.12em] rounded-[0.125rem] {{ $karya->status === 'TERBIT' ? 'bg-[#354638] text-[#FBF9F2] dark:bg-[#A5B18A] dark:text-[#171D18]' : 'bg-[#7A271A] text-[#FBF9F2]' }}">
                    {{ $karya->status }}
                  </span>
                </td>
                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                  <div class="inline-flex items-center gap-2">
                    <form method="POST" action="{{ route('dasbor.admin.karya.moderasi', $karya) }}">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="{{ $karya->status === 'TERBIT' ? 'DITANGGUHKAN' : 'TERBIT' }}" />
                      <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-[0.25rem] border {{ $karya->status === 'TERBIT' ? 'border-[#D4A943] bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2]' : 'border-[#354638] bg-[#354638] text-[#FBF9F2]' }}">
                        {{ $karya->status === 'TERBIT' ? 'Tangguhkan' : 'Terbitkan Kembali' }}
                      </button>
                    </form>
                    <form method="POST" action="{{ route('dasbor.admin.karya.hapus', $karya) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-[0.25rem] border border-[#BA1A1A] text-[#BA1A1A] dark:text-[#FFDAD6] hover:bg-[#BA1A1A] hover:text-[#FBF9F2]">
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>

    {{-- 2. Pengelolaan Akun Pengguna & Laporan Data Sistem --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      <section class="lg:col-span-8">
        <div class="pb-4 mb-5 border-b border-[#D6D1C2] dark:border-[#3A4637]">
          <p class="label-caps text-[#354638] dark:text-[#A5B18A]">MANAJEMEN AKUN</p>
          <h2 class="mt-1 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Daftar Akun Pengguna</h2>
        </div>

        <div class="overflow-x-auto bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem]">
          <table class="w-full text-left border-collapse text-sm">
            <thead>
              <tr class="bg-[#EAE5D5] dark:bg-[#20291F] border-b border-[#D6D1C2] dark:border-[#3A4637] text-xs uppercase tracking-[0.1em] text-[#302C25] dark:text-[#F1EBDD]">
                <th class="py-3 px-4">Nama</th>
                <th class="py-3 px-4">Surel</th>
                <th class="py-3 px-4">Peran</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#D6D1C2] dark:divide-[#3A4637]">
              @foreach($daftar_pengguna as $akun)
                <tr>
                  <td class="py-3 px-4 font-medium text-[#302C25] dark:text-[#F1EBDD]">{{ $akun->nama }}</td>
                  <td class="py-3 px-4 text-xs text-[#68705C] dark:text-[#B8BDAA]">{{ $akun->surel }}</td>
                  <td class="py-3 px-4 uppercase text-xs font-semibold text-[#354638] dark:text-[#D4A943]">{{ $akun->peran }}</td>
                  <td class="py-3 px-4 text-xs font-semibold {{ $akun->aktif ? 'text-[#354638] dark:text-[#A5B18A]' : 'text-[#BA1A1A] dark:text-[#FFDAD6]' }}">
                    {{ $akun->aktif ? 'Aktif' : 'Nonaktif' }}
                  </td>
                  <td class="py-3 px-4 text-right">
                    @if(! $akun->adalahAdmin())
                      <form method="POST" action="{{ route('dasbor.admin.pengguna.status', $akun) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-3 py-1 text-xs font-semibold border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] rounded-[0.25rem] hover:bg-[#354638] hover:text-[#FBF9F2]">
                          {{ $akun->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                      </form>
                    @else
                      <span class="text-xs text-[#68705C] dark:text-[#B8BDAA]">Terlindungi</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>

      {{-- Laporan Data Sistem (Distribusi Kategori & Seniman) --}}
      <section class="lg:col-span-4 space-y-6">
        <div class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6">
          <p class="label-caps text-[#354638] dark:text-[#D4A943]">LAPORAN DATA SISTEM</p>
          <h2 class="mt-1 font-display text-xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Distribusi Kategori Karya</h2>
          <div class="mt-5 space-y-3.5">
            @foreach($laporan_kategori as $lap)
              <div>
                <div class="flex justify-between text-xs font-medium text-[#302C25] dark:text-[#F1EBDD] mb-1">
                  <span>{{ $lap->nama }}</span>
                  <span class="tabular-nums font-semibold">{{ $lap->karya_seni_count }} Karya</span>
                </div>
                <div class="h-2 w-full bg-[#EAE5D5] dark:bg-[#171D18] overflow-hidden">
                  <div class="h-full bg-[#354638] dark:bg-[#D4A943]" style="width: {{ $lap->persentase }}%"></div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="bg-[#EAE5D5] dark:bg-[#20291F] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6">
          <p class="label-caps text-[#354638] dark:text-[#D4A943]">RINGKASAN SENIMAN</p>
          <ul class="mt-4 divide-y divide-[#D6D1C2] dark:divide-[#3A4637] text-sm">
            @foreach($daftar_seniman as $sen)
              <li class="py-2.5 flex items-center justify-between gap-3">
                <a href="{{ route('seniman.profil', $sen->slug) }}" class="font-medium text-[#302C25] dark:text-[#F1EBDD] hover:underline truncate">{{ $sen->nama_lengkap }}</a>
                <span class="text-xs text-[#68705C] dark:text-[#B8BDAA] tabular-nums shrink-0">{{ $sen->karya_seni_count }} karya · {{ $sen->riwayat_pameran_count }} pameran</span>
              </li>
            @endforeach
          </ul>
        </div>
      </section>
    </div>
  </div>
@endsection
