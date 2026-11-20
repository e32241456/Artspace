@extends('layouts.utama')

@section('konten')
  <section class="max-w-2xl mx-auto px-4 py-24 text-center">
    <p class="label-caps text-[#354638] dark:text-[#D4A943]">HALAMAN TIDAK DITEMUKAN · 404</p>
    <h1 class="mt-3 font-display text-4xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Konten Tidak Tersedia</h1>
    <p class="mt-4 text-sm sm:text-base text-[#68705C] dark:text-[#B8BDAA] leading-relaxed">
      Karya seni, profil seniman, atau alamat halaman yang Anda tuju tidak ditemukan pada arsip ARTSPACE.
    </p>
    <div class="mt-8 flex flex-wrap justify-center gap-3">
      <a href="{{ route('beranda') }}" class="px-6 py-3 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
        Kembali ke Beranda
      </a>
      <a href="{{ route('seniman.daftar') }}" class="px-6 py-3 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
        Temukan Seniman
      </a>
    </div>
  </section>
@endsection
