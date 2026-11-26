// Interaksi Vanilla JavaScript ARTSPACE (Laravel 13 + Blade + Tailwind CSS)
// Menangani Light & Dark Mode, menu mobile, filter masonry dinamis, scroll reveal,
// perbesaran gambar detail, tab dasbor seniman, formulir ubah inline, fallback gambar,
// serta interaksi pencarian/filter/simulasi khusus pratinjau statis ([data-demo-prototype]).

function inisialisasiTema() {
  const tombolTema = document.querySelectorAll('[data-sakelar-tema]');
  tombolTema.forEach((btn) => {
    btn.addEventListener('click', () => {
      const aktifGelap = document.documentElement.classList.toggle('dark');
      try {
        window.localStorage.setItem('artspace_tema', aktifGelap ? 'dark' : 'light');
      } catch {
        // Abaikan jika penyimpanan lokal dibatasi peramban
      }
    });
  });
}

function inisialisasiMenuMobile() {
  const tombolBuka = document.querySelector('[data-buka-mobile]');
  const tombolTutup = document.querySelectorAll('[data-tutup-mobile]');
  const drawer = document.querySelector('[data-drawer-mobile]');

  if (!tombolBuka || !drawer) return;

  const aturTerbuka = (terbuka) => {
    drawer.classList.toggle('hidden', !terbuka);
    document.body.classList.toggle('overflow-hidden', terbuka);
  };

  tombolBuka.addEventListener('click', () => aturTerbuka(true));
  tombolTutup.forEach((btn) => btn.addEventListener('click', () => aturTerbuka(false)));
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !drawer.classList.contains('hidden')) {
      aturTerbuka(false);
    }
  });
}

function perbaruiGayaTombolFilter(tombolFilter, kategoriAktif) {
  tombolFilter.forEach((btn) => {
    const aktif = btn.dataset.filterMasonry === kategoriAktif;
    btn.setAttribute('aria-pressed', String(aktif));

    if (aktif) {
      btn.classList.remove(
        'bg-[#FBF9F2]',
        'text-[#302C25]',
        'border-[#D6D1C2]',
        'hover:border-[#354638]',
        'dark:bg-[#293326]',
        'dark:text-[#F1EBDD]',
        'dark:border-[#3A4637]',
        'dark:hover:border-[#D4A943]'
      );
      btn.classList.add(
        'bg-[#354638]',
        'text-[#FBF9F2]',
        'border-[#354638]',
        'dark:bg-[#D4A943]',
        'dark:text-[#302C25]',
        'dark:border-[#D4A943]'
      );
    } else {
      btn.classList.remove(
        'bg-[#354638]',
        'text-[#FBF9F2]',
        'border-[#354638]',
        'dark:bg-[#D4A943]',
        'dark:text-[#302C25]',
        'dark:border-[#D4A943]'
      );
      btn.classList.add(
        'bg-[#FBF9F2]',
        'text-[#302C25]',
        'border-[#D6D1C2]',
        'hover:border-[#354638]',
        'dark:bg-[#293326]',
        'dark:text-[#F1EBDD]',
        'dark:border-[#3A4637]',
        'dark:hover:border-[#D4A943]'
      );
    }
  });
}

function inisialisasiFilterMasonry() {
  const tombolFilter = document.querySelectorAll('[data-filter-masonry]');
  const kartuKarya = document.querySelectorAll('[data-kartu-karya]');
  const pesanKosong = document.querySelector('[data-masonry-kosong]');
  const jumlahTampil = document.querySelector('[data-jumlah-karya-tampil]');
  const modePrototype = document.body.hasAttribute('data-demo-prototype');

  if (kartuKarya.length === 0) return;

  let kategoriSaatIni = 'semua';
  let kataKunciSaatIni = '';

  const terapkanPenyaringan = () => {
    let terlihat = 0;
    const q = kataKunciSaatIni.trim().toLowerCase();

    if (tombolFilter.length > 0) {
      perbaruiGayaTombolFilter(tombolFilter, kategoriSaatIni);
    }

    kartuKarya.forEach((kartu) => {
      const cocokKategori = kategoriSaatIni === 'semua' || kartu.dataset.kategori === kategoriSaatIni;
      const teksCari = (kartu.dataset.cari || kartu.textContent || '').toLowerCase();
      const cocokCari = q === '' || teksCari.includes(q);
      const cocok = cocokKategori && cocokCari;
      kartu.classList.toggle('hidden', !cocok);
      if (cocok) {
        terlihat++;
      }
    });

    if (jumlahTampil) {
      jumlahTampil.textContent = String(terlihat);
    }

    if (pesanKosong) {
      pesanKosong.classList.toggle('hidden', terlihat > 0);
    }

    // Panel seniman cocok di beranda saat pencarian aktif pada mode prototype statis
    const panelSenimanCocok = document.querySelector('[data-panel-seniman-cocok]');
    const kartuSenimanCocok = document.querySelectorAll('[data-seniman-cocok-item]');
    if (panelSenimanCocok && kartuSenimanCocok.length > 0) {
      let cocokSeniman = 0;
      kartuSenimanCocok.forEach((item) => {
        const cocok = q !== '' && (item.dataset.cari || '').toLowerCase().includes(q);
        item.classList.toggle('hidden', !cocok);
        if (cocok) cocokSeniman++;
      });
      panelSenimanCocok.classList.toggle('hidden', q === '' || cocokSeniman === 0);
    }

    // Ringkasan status pencarian di beranda / jelajahi
    const infoCari = document.querySelector('[data-info-pencarian]');
    const labelKataKunci = document.querySelector('[data-label-kata-kunci]');
    const judulBeranda = document.querySelector('[data-judul-beranda]');
    if (infoCari) {
      infoCari.classList.toggle('hidden', q === '' && kategoriSaatIni === 'semua');
    }
    if (labelKataKunci) {
      labelKataKunci.textContent = kataKunciSaatIni.trim();
    }
    if (judulBeranda) {
      judulBeranda.textContent =
        q !== ''
          ? `Hasil Pencarian: “${kataKunciSaatIni.trim()}”`
          : 'Temukan Karya & Perupa Kontemporer';
    }
  };

  tombolFilter.forEach((btn) => {
    btn.addEventListener('click', () => {
      kategoriSaatIni = btn.dataset.filterMasonry || 'semua';
      const selectKat = document.querySelector('select[data-select-kategori]');
      if (selectKat) {
        selectKat.value = kategoriSaatIni;
      }
      terapkanPenyaringan();
    });
  });

  if (modePrototype) {
    const params = new URLSearchParams(window.location.search);
    const cariParam = params.get('cari') || '';
    const katParam = params.get('kategori') || 'semua';
    kataKunciSaatIni = cariParam;
    kategoriSaatIni = katParam;

    document.querySelectorAll('input[name="cari"]').forEach((inp) => {
      inp.value = cariParam;
    });
    const selectKat = document.querySelector('select[data-select-kategori]');
    if (selectKat) {
      selectKat.value = katParam;
      selectKat.addEventListener('change', () => {
        kategoriSaatIni = selectKat.value || 'semua';
        terapkanPenyaringan();
      });
    }

    // Filter langsung saat mengetik atau submit form di halaman katalog/beranda
    const formFilterLokal = document.querySelectorAll('form[data-form-cari-karya]');
    formFilterLokal.forEach((form) => {
      const inputCari = form.querySelector('input[name="cari"]');
      if (inputCari) {
        inputCari.addEventListener('input', () => {
          kataKunciSaatIni = inputCari.value;
          terapkanPenyaringan();
        });
      }
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (inputCari) kataKunciSaatIni = inputCari.value;
        const sel = form.querySelector('select[name="kategori"]');
        if (sel) kategoriSaatIni = sel.value || 'semua';
        terapkanPenyaringan();
      });
    });

    const tombolReset = document.querySelectorAll('[data-reset-filter]');
    tombolReset.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        kataKunciSaatIni = '';
        kategoriSaatIni = 'semua';
        document.querySelectorAll('input[name="cari"]').forEach((inp) => {
          inp.value = '';
        });
        if (selectKat) selectKat.value = 'semua';
        terapkanPenyaringan();
      });
    });

    if (cariParam !== '' || katParam !== 'semua') {
      terapkanPenyaringan();
    }
  }
}

function inisialisasiPencarianSenimanPrototype() {
  if (!document.body.hasAttribute('data-demo-prototype')) return;

  const kartuSeniman = document.querySelectorAll('[data-kartu-seniman]');
  if (kartuSeniman.length === 0) return;

  const pesanKosong = document.querySelector('[data-seniman-kosong]');
  const infoCari = document.querySelector('[data-info-cari-seniman]');
  const jumlahTampil = document.querySelector('[data-jumlah-seniman-tampil]');
  const labelCari = document.querySelector('[data-label-cari-seniman]');

  const saring = (kataKunci) => {
    const q = kataKunci.trim().toLowerCase();
    let terlihat = 0;
    kartuSeniman.forEach((kartu) => {
      const teks = (kartu.dataset.cari || kartu.textContent || '').toLowerCase();
      const cocok = q === '' || teks.includes(q);
      kartu.classList.toggle('hidden', !cocok);
      if (cocok) terlihat++;
    });

    if (jumlahTampil) jumlahTampil.textContent = String(terlihat);
    if (labelCari) labelCari.textContent = kataKunci.trim();
    if (infoCari) infoCari.classList.toggle('hidden', q === '');
    if (pesanKosong) pesanKosong.classList.toggle('hidden', terlihat > 0);
  };

  const params = new URLSearchParams(window.location.search);
  const cariAwal = params.get('cari') || '';
  const formCari = document.querySelector('form[data-form-cari-seniman]');
  const inputCari = formCari ? formCari.querySelector('input[name="cari"]') : null;

  if (inputCari) {
    inputCari.value = cariAwal;
    inputCari.addEventListener('input', () => saring(inputCari.value));
  }
  if (formCari) {
    formCari.addEventListener('submit', (e) => {
      e.preventDefault();
      saring(inputCari ? inputCari.value : '');
    });
  }

  document.querySelectorAll('[data-reset-seniman]').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      if (inputCari) inputCari.value = '';
      saring('');
    });
  });

  if (cariAwal !== '') {
    saring(cariAwal);
  }
}

function inisialisasiScrollReveal() {
  const kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (kurangiGerak || typeof IntersectionObserver === 'undefined') return;

  const elemen = document.querySelectorAll('.reveal-on-scroll');
  if (elemen.length === 0) return;

  const pengamat = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.remove('is-pending');
          entry.target.classList.add('is-visible');
          pengamat.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.05, rootMargin: '0px 0px -20px 0px' }
  );

  elemen.forEach((el) => {
    const rect = el.getBoundingClientRect();
    if (rect.top > window.innerHeight * 0.95) {
      el.classList.add('is-pending');
      pengamat.observe(el);
    }
  });
}

function inisialisasiZoomDetail() {
  const pemicu = document.querySelectorAll('[data-pemicu-zoom]');
  const modal = document.querySelector('[data-modal-zoom]');
  const gambarModal = document.querySelector('[data-gambar-zoom]');
  const judulModal = document.querySelector('[data-judul-zoom]');
  const tombolTutup = document.querySelectorAll('[data-tutup-zoom]');

  if (!modal || !gambarModal || pemicu.length === 0) return;

  const tutup = () => {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  };

  pemicu.forEach((btn) => {
    btn.addEventListener('click', () => {
      gambarModal.src = btn.dataset.zoomSrc || '';
      gambarModal.alt = btn.dataset.zoomJudul || 'Pratinjau Karya';
      if (judulModal) {
        judulModal.textContent = btn.dataset.zoomJudul || '';
      }
      modal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    });
  });

  tombolTutup.forEach((btn) => btn.addEventListener('click', tutup));
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
      tutup();
    }
  });
}

function inisialisasiDasborSeniman() {  // Format otomatis harga Rupiah dengan pemisah ribuan
  const inputHarga = document.querySelectorAll('[data-format-rupiah]');

  inputHarga.forEach((input) => {
    const formatRupiah = (nilai) => {
      const angka = String(nilai).replace(/\D/g, '');
      return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    };

    input.value = formatRupiah(input.value);

    input.addEventListener('input', () => {
      input.value = formatRupiah(input.value);
    });

    const form = input.closest('form');

    if (form) {
      form.addEventListener('submit', () => {
        input.value = input.value.replace(/\./g, '');
      });
    }
  });
  const tombolTab = document.querySelectorAll('[data-tab-dasbor]');
  const panelTab = document.querySelectorAll('[data-panel-dasbor]');

  if (tombolTab.length > 0 && panelTab.length > 0) {
    const aktifkanTab = (nama) => {
      tombolTab.forEach((btn) => {
        const aktif = btn.dataset.tabDasbor === nama;
        btn.setAttribute('aria-selected', String(aktif));
        if (aktif) {
          btn.classList.remove(
            'bg-[#FBF9F2]',
            'text-[#302C25]',
            'dark:bg-[#293326]',
            'dark:text-[#F1EBDD]',
            'border-[#D6D1C2]',
            'dark:border-[#3A4637]'
          );
          btn.classList.add(
            'bg-[#354638]',
            'text-[#FBF9F2]',
            'dark:bg-[#D4A943]',
            'dark:text-[#302C25]',
            'border-[#354638]',
            'dark:border-[#D4A943]'
          );
        } else {
          btn.classList.remove(
            'bg-[#354638]',
            'text-[#FBF9F2]',
            'dark:bg-[#D4A943]',
            'dark:text-[#302C25]',
            'border-[#354638]',
            'dark:border-[#D4A943]'
          );
          btn.classList.add(
            'bg-[#FBF9F2]',
            'text-[#302C25]',
            'dark:bg-[#293326]',
            'dark:text-[#F1EBDD]',
            'border-[#D6D1C2]',
            'dark:border-[#3A4637]'
          );
        }
      });

      panelTab.forEach((panel) => {
        panel.classList.toggle('hidden', panel.dataset.panelDasbor !== nama);
      });
    };

const parameterUrl = new URLSearchParams(window.location.search);
const tabAwal = parameterUrl.get('tab') || 'karya';

aktifkanTab(
  Array.from(tombolTab).some((btn) => btn.dataset.tabDasbor === tabAwal)
    ? tabAwal
    : 'karya'
);

tombolTab.forEach((btn) => {
  btn.addEventListener('click', () => {
    const namaTab = btn.dataset.tabDasbor || 'karya';

    aktifkanTab(namaTab);

    const url = new URL(window.location.href);
    url.searchParams.set('tab', namaTab);
    window.history.replaceState({}, '', url);
  });
});
  }

  document.querySelectorAll('[data-buka-edit]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const targetId = btn.dataset.bukaEdit;
      if (!targetId) return;
      const form = document.getElementById(targetId);
      if (form) {
        form.classList.toggle('hidden');
      }
    });
  });
}

function tampilkanPesanSimulasi(pesan) {
  const wadah = document.querySelector('[data-banner-simulasi]');
  const teks = document.querySelector('[data-teks-simulasi]');
  if (wadah && teks) {
    teks.textContent = pesan;
    wadah.classList.remove('hidden');
    wadah.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
}

function inisialisasiSimulasiPrototype() {
  if (!document.body.hasAttribute('data-demo-prototype')) return;

  // Simulasi form Masuk (/masuk/)
  const formMasuk = document.querySelector('form[data-demo-masuk]');
  if (formMasuk) {
    formMasuk.addEventListener('submit', (e) => {
      e.preventDefault();
      const surel = (formMasuk.querySelector('input[name="surel"]')?.value || '').trim().toLowerCase();
      if (surel.includes('admin')) {
        window.location.href = '/dasbor-admin/?simulasi=masuk-admin';
      } else {
        window.location.href = '/dasbor-seniman/?simulasi=masuk-seniman';
      }
    });
  }

  // Simulasi form Daftar Seniman (/daftar/)
  const formDaftar = document.querySelector('form[data-demo-daftar]');
  if (formDaftar) {
    formDaftar.addEventListener('submit', (e) => {
      e.preventDefault();
      const sandi = formDaftar.querySelector('input[name="kata_sandi"]')?.value || '';
      const konf = formDaftar.querySelector('input[name="kata_sandi_confirmation"]')?.value || '';
      if (sandi !== konf) {
        tampilkanPesanSimulasi('Konfirmasi kata sandi tidak cocok. Silakan periksa kembali isian formulir.');
        return;
      }
      window.location.href = '/dasbor-seniman/?simulasi=daftar-seniman';
    });
  }

  // Simulasi aksi form di Dasbor Seniman & Dasbor Admin (tanpa klaim penyimpanan database)
  document.querySelectorAll('form[data-demo-aksi]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const pesan = form.dataset.demoAksi || 'Aksi demonstrasi dijalankan pada mode pratinjau statis (belum terhubung ke backend PostgreSQL).';
      tampilkanPesanSimulasi(pesan);
    });
  });

  // Tampilkan notifikasi jika baru diarahkan dari simulasi masuk/daftar
  const params = new URLSearchParams(window.location.search);
  const simulasi = params.get('simulasi');
  if (simulasi === 'masuk-seniman') {
    tampilkanPesanSimulasi('Mode Simulasi: Anda membuka tampilan pratinjau Dasbor Seniman. Autentikasi dan penyimpanan database aktif setelah backend Laravel 13 & PostgreSQL dijalankan.');
  } else if (simulasi === 'daftar-seniman') {
    tampilkanPesanSimulasi('Mode Simulasi: Formulir pendaftaran seniman lolos validasi pratinjau. Penyimpanan akun nyata memerlukan backend Laravel 13 & PostgreSQL.');
  } else if (simulasi === 'masuk-admin') {
    tampilkanPesanSimulasi('Mode Simulasi: Anda membuka tampilan pratinjau Dasbor Admin. Moderasi dan pengelolaan akun nyata memerlukan backend Laravel 13 & PostgreSQL.');
  }
}

function inisialisasiFallbackDanNotifikasi() {
  document.querySelectorAll('img[data-gambar-karya]').forEach((img) => {
    const tampilFallback = () => {
      const fallback = img.parentElement ? img.parentElement.querySelector('[data-fallback-gambar]') : null;
      if (fallback) {
        img.classList.add('hidden');
        fallback.classList.remove('hidden');
      }
    };
    img.addEventListener('error', tampilFallback);
    if (img.complete && img.naturalWidth === 0) {
      tampilFallback();
    }
  });

  document.querySelectorAll('[data-tutup-notifikasi]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const banner = btn.closest('[role="status"], [role="alert"], [data-banner-simulasi]');
      if (banner) {
        banner.classList.add('hidden');
      }
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  inisialisasiTema();
  inisialisasiMenuMobile();
  inisialisasiFilterMasonry();
  inisialisasiPencarianSenimanPrototype();
  inisialisasiScrollReveal();
  inisialisasiZoomDetail();
  inisialisasiDasborSeniman();
  inisialisasiSimulasiPrototype();
  inisialisasiFallbackDanNotifikasi();
});
