import fs from 'node:fs';
import path from 'node:path';

/**
 * Generator Prototype Statis ARTSPACE untuk deployment Vercel (folder /dist).
 * Menggunakan aset CSS & JS hasil kompilasi Laravel Vite (public/build) dan
 * gambar asli dari public/images/ tanpa mengubah kode backend Laravel 13.
 */

const KATEGORI = [
  { id: 1, nama: 'Lukisan', slug: 'lukisan', deskripsi: 'Karya lukis minyak, akrilik, pigmen alam, dan media datar kontemporer.' },
  { id: 2, nama: 'Patung & Keramik', slug: 'patung-keramik', deskripsi: 'Karya tiga dimensi berbahan perunggu, batu vulkanik, dan keramik stoneware.' },
  { id: 3, nama: 'Fotografi', slug: 'fotografi', deskripsi: 'Fotografi arsitektur, analog format besar, dan cetakan arsip.' },
  { id: 4, nama: 'Tekstil & Relief', slug: 'tekstil-relief', deskripsi: 'Tenun arsitektural, serat alam, dan relief dinding mineral.' },
  { id: 5, nama: 'Kertas & Media Campuran', slug: 'kertas-media-campuran', deskripsi: 'Kolase kertas serat murbei, tinta sumi, dan eksplorasi kertas kapas.' },
];

const GAMBAR_STITCH = {
  ruang: 'ruang-yang-tertinggal.png',
  senja: 'di-balik-senja.png',
  fragmen: 'fragmen-kehidupan.png',
  warna: 'warna-dalam-keheningan.png',
};

const DAFTAR_GAMBAR_STITCH = Object.values(GAMBAR_STITCH);

const SENIMAN = [
  {
    id: 1,
    slug: 'baskoro-wijaya',
    nama_lengkap: 'Baskoro Wijaya',
    kota: 'Yogyakarta',
    disiplin: 'Lukisan Mineral & Media Campuran',
    foto_profil: null,
    biografi_singkat: 'Perupa lukis dan media campuran asal Yogyakarta yang meneliti lapisan pigmen tanah vulkanik dan struktur ruang sunyi.',
    biografi: 'Baskoro Wijaya bekerja dengan pigmen tanah vulkanik, cat minyak, lilin dingin, dan kertas serat murbei di atas linen mentah. Karyanya membaca ulang bobot material geologis dalam komposisi bidang warna arsitektural.',
    latar_belakang: 'Sarjana Seni Lukis Institut Seni Indonesia (ISI) Yogyakarta dan alumnus residensi seni rupa kontemporer di Basel serta Tokyo.',
    perjalanan_berkesenian: 'Memulai praktik seni rupa sejak 2006 dengan eksplorasi cat minyak figuratif sebelum beralih pada abstraksi tektonik berbahan mineral alami pada 2015.',
    pengalaman: '18 tahun praktik studio penuh waktu, dosen tamu seni lukis kontemporer, dan kolaborator ruang pamer arsitektur Asia Tenggara.',
    pameran: [
      { id: 1, nama_pameran: 'Lapisan Sunyi: Studi Pigmen Tanah', lokasi: 'Galeri Nasional Indonesia, Jakarta', tahun: 2026, deskripsi: 'Pameran tunggal menampilkan dua belas lukisan impasto linen mentah berskala besar.' },
      { id: 2, nama_pameran: 'Tectonic Fields Asia Tenggara', lokasi: 'Singapore Art Museum, Singapura', tahun: 2025, deskripsi: 'Pameran kelompok lintas negara mengenai materialitas bumi dalam seni rupa modern.' },
      { id: 3, nama_pameran: 'Ruang & Residu', lokasi: 'Jogja National Museum, Yogyakarta', tahun: 2023, deskripsi: 'Pameran duo mengeksplorasi arsip tanah vulkanik Merapi pada bidang kanvas.' },
    ],
  },
  {
    id: 2,
    slug: 'ratna-kusumawati',
    nama_lengkap: 'Ratna Kusumawati',
    kota: 'Bandung',
    disiplin: 'Keramik Stoneware & Patung Perunggu',
    foto_profil: null,
    biografi_singkat: 'Pematung dan perupa keramik berbasis di Bandung yang merancang bejana kontemplatif serta bentuk organik berbahan tanah liat dan perunggu.',
    biografi: 'Ratna Kusumawati mengolah tanah liat lokal Jawa Barat dengan pembakaran tungku kayu suhu tinggi serta pengecoran perunggu teknik lost-wax untuk menghadirkan keheningan bentuk arsitektural.',
    latar_belakang: 'Magister Seni Rupa Fakultas Seni Rupa dan Desain (FSRD) ITB Bandung; pernah menjalani program studi keramik tradisional di Mashiko, Jepang.',
    perjalanan_berkesenian: 'Mengembangkan teknik glasir abu sekam dan oksida tembaga sejak 2012 untuk menghasilkan patina zaitun matte khas pada karya tiga dimensi.',
    pengalaman: 'Pendiri Studio Tanah & Logam Bandung, kurator tamu Biennale Keramik Indonesia, dan penerima hibah riset kriya kontemporer.',
    pameran: [
      { id: 4, nama_pameran: 'Bejana Keheningan', lokasi: 'Selasar Sunaryo Art Space, Bandung', tahun: 2026, deskripsi: 'Pameran tunggal dua puluh karya bejana stoneware dan patung perunggu.' },
      { id: 5, nama_pameran: 'Forms of Earth & Fire', lokasi: 'Museum MACAN, Jakarta', tahun: 2024, deskripsi: 'Eksplorasi keramik kontemporer Nusantara dan dialognya dengan ruang arsitektur.' },
    ],
  },
  {
    id: 3,
    slug: 'darmawan-setiadi',
    nama_lengkap: 'Darmawan Setiadi',
    kota: 'Jakarta',
    disiplin: 'Fotografi Arsitektur & Cetakan Arsip',
    foto_profil: null,
    biografi_singkat: 'Fotografer arsitektur format besar yang merekam pertemuan cahaya matahari tropis, bayangan beton, dan ritme ruang publik.',
    biografi: 'Darmawan Setiadi bekerja secara eksklusif menggunakan kamera analog format besar 4x5 inci dan cetakan arsip kertas kapas untuk menangkap geometri cahaya alami tanpa manipulasi digital.',
    latar_belakang: 'Lulusan Arsitektur Universitas Indonesia yang memperdalam fotografi dokumenter dan pencetakan kamar gelap di Amsterdam.',
    perjalanan_berkesenian: 'Sejak 2014 mendokumentasikan arsitektur modernis tropis Indonesia dalam seri monografi fotografi hitam-putih dan nada hangat.',
    pengalaman: 'Kontributor monografi arsitektur Nusantara dan pengajar lokakarya fotografi analog format besar.',
    pameran: [
      { id: 6, nama_pameran: 'Bayangan Kolonade', lokasi: 'Erasmus Huis, Jakarta', tahun: 2025, deskripsi: 'Seri cetak arsip format besar mengenai cahaya sore pada bangunan publik bersejarah.' },
      { id: 7, nama_pameran: 'Monolith Tropis', lokasi: 'Biennale Arsitektur Indonesia, Semarang', tahun: 2024, deskripsi: 'Instalasi fotografi berskala dinding menampilkan ritme struktur beton modernis.' },
    ],
  },
  {
    id: 4,
    slug: 'sekar-ayu-prameswari',
    nama_lengkap: 'Sekar Ayu Prameswari',
    kota: 'Denpasar',
    disiplin: 'Tekstil Serat Alam & Relief Dinding',
    foto_profil: null,
    biografi_singkat: 'Perupa tekstil dan relief kontemporer asal Bali yang memadukan pewarna alam kunyit, daun ketapang, dan batu kapur ukir.',
    biografi: 'Sekar Ayu Prameswari menjembatani tradisi tenun tangan dan relief mineral kontemporer melalui komposisi tekstil berskala arsitektural dengan palet oker, zaitun, dan krem alami.',
    latar_belakang: 'Sarjana Desain Tekstil Institut Seni Indonesia (ISI) Denpasar dan peneliti pewarna alami botani Nusantara.',
    perjalanan_berkesenian: 'Berkolaborasi bersama penenun desa di Bali Timur dan Nusa Tenggara untuk menciptakan tekstil pamer non-komersial berbasis arsip botani.',
    pengalaman: 'Perupa residensi Textile Art Kyoto 2024 dan narasumber pelestarian serat alami kontemporer.',
    pameran: [
      { id: 8, nama_pameran: 'Tenun Tanah & Oker', lokasi: 'Museum Puri Lukisan, Ubud', tahun: 2026, deskripsi: 'Instalasi tekstil tenun serat rami dengan pewarnaan kulit kayu dan kunyit.' },
      { id: 9, nama_pameran: 'Serat Ingatan Nusantara', lokasi: 'Bentara Budaya, Bali', tahun: 2023, deskripsi: 'Pameran kolaboratif tekstil arsitektural dan relief batu kapur.' },
    ],
  },
];

const KARYA = [
  {
    id: 1,
    slug: 'strata-zaitun-oker-iv',
    alias_slug: 'strata-zaitun-dan-oker-iv',
    seniman_slug: 'baskoro-wijaya',
    kategori_slug: 'lukisan',
    judul: 'Strata Zaitun & Oker IV',
    deskripsi: 'Komposisi impasto tebal berbahan pigmen tanah vulkanik, cat minyak, dan lilin dingin di atas linen Belgia mentah tanpa bingkai luar.',
    tahun_pembuatan: 2026,
    media_bahan: 'Cat minyak, pigmen tanah vulkanik, dan lilin dingin di atas linen mentah',
    dimensi: '195 × 145 cm',
    informasi_tambahan: 'Karya unik seri Strata Geologis; dikerjakan selama empat bulan dengan teknik pisau palet berlapis.',
    harga_opsional: 285000000,
    gambar_stitch: GAMBAR_STITCH.warna,
    foto_karya: `/images/${GAMBAR_STITCH.warna}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 2,
    slug: 'bejana-stoneware-lumut-tinggi',
    seniman_slug: 'ratna-kusumawati',
    kategori_slug: 'patung-keramik',
    judul: 'Bejana Stoneware Lumut Tinggi',
    deskripsi: 'Eksplorasi vertikalitas bejana tanah liat bakar suhu 1.280°C dengan glasir abu sekam dan aksen mineral kuning mustard alami.',
    tahun_pembuatan: 2026,
    media_bahan: 'Keramik stoneware bakar tungku kayu, glasir abu sekam',
    dimensi: '82 × 28 × 28 cm',
    informasi_tambahan: 'Dibentuk secara manual dengan teknik pilin (coiling) tanpa cetakan pabrik.',
    harga_opsional: 64000000,
    gambar_stitch: GAMBAR_STITCH.fragmen,
    foto_karya: `/images/${GAMBAR_STITCH.fragmen}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 3,
    slug: 'kolonade-pukul-empat',
    seniman_slug: 'darmawan-setiadi',
    kategori_slug: 'fotografi',
    judul: 'Kolonade Pukul Empat',
    deskripsi: 'Rekaman analog format besar 4×5 inci mengenai garis cahaya sore yang membelah selasar beton modernis dalam keheningan.',
    tahun_pembuatan: 2025,
    media_bahan: 'Cetakan arsip kertas kapas 310 gsm dari negatif film 4×5 inci',
    dimensi: '110 × 145 cm',
    informasi_tambahan: 'Edisi terbatas 1 dari 5; dilengkapi sertifikat arsip studio fotografer.',
    harga_opsional: null,
    gambar_stitch: GAMBAR_STITCH.ruang,
    foto_karya: `/images/${GAMBAR_STITCH.ruang}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 4,
    slug: 'arsip-kertas-murbei-07',
    seniman_slug: 'baskoro-wijaya',
    kategori_slug: 'kertas-media-campuran',
    judul: 'Arsip Kertas Murbei No. 07',
    deskripsi: 'Kolase kertas buatan tangan berbahan kulit pohon murbei, sapuan pigmen oker, dan bidang zaitun tua yang disusun dengan keseimbangan geometris.',
    tahun_pembuatan: 2026,
    media_bahan: 'Kolase kertas murbei, pigmen mineral oker, dan tinta karbon di atas papan arsip',
    dimensi: '90 × 90 cm',
    informasi_tambahan: 'Bagian dari seri riset kertas arsip Nusantara.',
    harga_opsional: 42000000,
    gambar_stitch: GAMBAR_STITCH.fragmen,
    foto_karya: `/images/${GAMBAR_STITCH.fragmen}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 5,
    slug: 'tenun-dinding-oker-senja',
    seniman_slug: 'sekar-ayu-prameswari',
    kategori_slug: 'tekstil-relief',
    judul: 'Tenun Dinding Oker Senja',
    deskripsi: 'Permadani dinding tenun tangan dari serat rami dan wol mentah yang dicelup menggunakan ekstrak kunyit tua, daun ketapang, dan lumpur sawah.',
    tahun_pembuatan: 2025,
    media_bahan: 'Serat rami, kapas tenun tangan, pewarna alami botani',
    dimensi: '180 × 125 cm',
    informasi_tambahan: 'Ditenun menggunakan alat tenun bukan mesin (ATBM) selama sembilan minggu.',
    harga_opsional: 115000000,
    gambar_stitch: GAMBAR_STITCH.senja,
    foto_karya: `/images/${GAMBAR_STITCH.senja}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 6,
    slug: 'studi-botani-tinta-sumi-ii',
    seniman_slug: 'baskoro-wijaya',
    kategori_slug: 'kertas-media-campuran',
    judul: 'Studi Botani Tinta Sumi II',
    deskripsi: 'Sketsa meditasi garis tunggal menggunakan kuas bambu, tinta sumi Jepang, dan sapuan tipis pigmen zaitun pada kertas kapas buatan tangan.',
    tahun_pembuatan: 2026,
    media_bahan: 'Tinta sumi dan cat air mineral di atas kertas kapas dekled 350 gsm',
    dimensi: '76 × 52 cm',
    informasi_tambahan: 'Dikerjakan langsung dari observasi kebun studio pada pagi hari.',
    harga_opsional: null,
    gambar_stitch: GAMBAR_STITCH.warna,
    foto_karya: `/images/${GAMBAR_STITCH.warna}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 7,
    slug: 'patung-bejana-perunggu-senyap',
    seniman_slug: 'ratna-kusumawati',
    kategori_slug: 'patung-keramik',
    judul: 'Bejana Perunggu Senyap',
    deskripsi: 'Karya patung cor perunggu padat dengan permukaan berpatina cokelat-zaitun hangat yang menangkap perubahan cahaya sepanjang hari.',
    tahun_pembuatan: 2025,
    media_bahan: 'Perunggu cor teknik lost-wax, patina oksida alami',
    dimensi: '48 × 36 × 34 cm',
    informasi_tambahan: 'Dicor di pengecoran logam tradisional Yogyakarta.',
    harga_opsional: 135000000,
    gambar_stitch: GAMBAR_STITCH.senja,
    foto_karya: `/images/${GAMBAR_STITCH.senja}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 8,
    slug: 'relief-kapur-geometri-iii',
    seniman_slug: 'sekar-ayu-prameswari',
    kategori_slug: 'tekstil-relief',
    judul: 'Relief Batu Kapur Geometri III',
    deskripsi: 'Ukiran dangkal pada panel batu kapur palimanan yang menonjolkan permainan bidang cekung, garis sejajar, dan bayangan alami.',
    tahun_pembuatan: 2024,
    media_bahan: 'Batu kapur alam pahat tangan dengan lapisan pelindung matte',
    dimensi: '120 × 100 × 7 cm',
    informasi_tambahan: 'Dirancang untuk ditempatkan pada dinding dengan pencahayaan menyamping.',
    harga_opsional: 98000000,
    gambar_stitch: GAMBAR_STITCH.fragmen,
    foto_karya: `/images/${GAMBAR_STITCH.fragmen}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 9,
    slug: 'paviliun-cahaya-utara',
    seniman_slug: 'darmawan-setiadi',
    kategori_slug: 'fotografi',
    judul: 'Paviliun Cahaya Utara',
    deskripsi: 'Dokumentasi ruang pamer minimalis saat sinar matahari pagi menyentuh permukaan lantai batu dan dinding plester kapur.',
    tahun_pembuatan: 2026,
    media_bahan: 'Cetakan pigmen arsip pada kertas Hahnemühle Photo Rag',
    dimensi: '100 × 150 cm',
    informasi_tambahan: 'Bagian dari seri Arsitektur Ruang Sunyi 2026.',
    harga_opsional: null,
    gambar_stitch: GAMBAR_STITCH.ruang,
    foto_karya: `/images/${GAMBAR_STITCH.ruang}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
  {
    id: 10,
    slug: 'selasar-batu-dan-hening',
    seniman_slug: 'darmawan-setiadi',
    kategori_slug: 'fotografi',
    judul: 'Selasar Batu & Hening',
    deskripsi: 'Komposisi perspektif simetris yang menyoroti tekstur dinding travertine dan proporsi ruang galeri kontemporer.',
    tahun_pembuatan: 2024,
    media_bahan: 'Cetakan pigmen arsip pada kertas kapas matte',
    dimensi: '85 × 125 cm',
    informasi_tambahan: 'Pernah dipamerkan pada Biennale Arsitektur Indonesia 2024.',
    harga_opsional: 38000000,
    gambar_stitch: GAMBAR_STITCH.ruang,
    foto_karya: `/images/${GAMBAR_STITCH.ruang}`,
    status: 'TERBIT',
    catatan_moderasi: null,
  },
];

const AKUN_PENGGUNA = [
  { id: 1, nama: 'Administrator ARTSPACE', surel: 'admin@artspace.id', peran: 'admin', aktif: true },
  { id: 2, nama: 'Baskoro Wijaya', surel: 'baskoro@artspace.id', peran: 'seniman', aktif: true },
  { id: 3, nama: 'Ratna Kusumawati', surel: 'ratna@artspace.id', peran: 'seniman', aktif: true },
  { id: 4, nama: 'Darmawan Setiadi', surel: 'darmawan@artspace.id', peran: 'seniman', aktif: true },
  { id: 5, nama: 'Sekar Ayu Prameswari', surel: 'sekarsari@artspace.id', peran: 'seniman', aktif: true },
];

function esc(val) {
  return String(val ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function formatRupiah(nominal) {
  if (nominal === null || nominal === undefined) return null;
  return 'Rp ' + Number(nominal).toLocaleString('id-ID');
}

function cariSeniman(slug) {
  return SENIMAN.find((s) => s.slug === slug);
}

function cariKategori(slug) {
  return KATEGORI.find((k) => k.slug === slug);
}

function tulisHalaman(distDir, relPath, html) {
  const fullPath = path.join(distDir, relPath);
  fs.mkdirSync(path.dirname(fullPath), { recursive: true });
  fs.writeFileSync(fullPath, html, 'utf-8');
}

function inisialSeniman(nama) {
  const bagian = String(nama || '')
    .trim()
    .split(/\s+/)
    .filter(Boolean);
  if (bagian.length === 0) return 'AS';
  if (bagian.length === 1) return bagian[0].slice(0, 2).toUpperCase();
  return (bagian[0][0] + bagian[bagian.length - 1][0]).toUpperCase();
}

function renderFotoSeniman(seniman, varian = 'avatar-md') {
  const inisial = esc(inisialSeniman(seniman.nama_lengkap));

  if (varian === 'avatar-sm') {
    if (seniman.foto_profil) {
      return `<img src="${esc(seniman.foto_profil)}" alt="Foto profil ${esc(seniman.nama_lengkap)}" class="h-12 w-12 object-cover shrink-0 border border-[#D6D1C2] dark:border-[#3A4637] bg-[#EAE5D5] dark:bg-[#20291F]" />`;
    }
    return `
      <div aria-label="Inisial ${esc(seniman.nama_lengkap)}" class="h-12 w-12 shrink-0 flex items-center justify-center bg-[#354638] dark:bg-[#20291F] border border-[#D4A943]/70 text-[#FBF9F2] dark:text-[#F1EBDD] rounded-[0.125rem] select-none">
        <span class="font-display text-base font-semibold tracking-[0.06em] text-[#D4A943]">${inisial}</span>
      </div>`;
  }

  if (varian === 'avatar-md') {
    if (seniman.foto_profil) {
      return `<img src="${esc(seniman.foto_profil)}" alt="${esc(seniman.nama_lengkap)}" class="h-14 w-14 object-cover shrink-0 border border-[#D4A943]/50 bg-[#171D18]" />`;
    }
    return `
      <div aria-label="Inisial ${esc(seniman.nama_lengkap)}" class="h-14 w-14 shrink-0 flex flex-col items-center justify-center bg-[#29382D] dark:bg-[#171D18] border border-[#D4A943]/60 rounded-[0.125rem] select-none">
        <span class="font-display text-lg font-semibold tracking-[0.08em] text-[#D4A943] leading-none">${inisial}</span>
        <span class="mt-1 h-[1.5px] w-5 bg-[#D4A943]/70"></span>
      </div>`;
  }

  if (varian === 'avatar-lg') {
    if (seniman.foto_profil) {
      return `<img src="${esc(seniman.foto_profil)}" alt="${esc(seniman.nama_lengkap)}" class="h-16 w-16 object-cover border-2 border-[#D4A943] shrink-0" />`;
    }
    return `
      <div aria-label="Inisial ${esc(seniman.nama_lengkap)}" class="h-16 w-16 shrink-0 flex flex-col items-center justify-center bg-[#29382D] dark:bg-[#171D18] border-2 border-[#D4A943] rounded-[0.125rem] select-none">
        <span class="font-display text-xl font-semibold tracking-[0.08em] text-[#FBF9F2] dark:text-[#F1EBDD] leading-none">${inisial}</span>
        <span class="mt-1.5 h-[2px] w-6 bg-[#D4A943]"></span>
      </div>`;
  }

  if (varian === 'kartu-direktori') {
    if (seniman.foto_profil) {
      return `
        <img data-gambar-karya src="${esc(seniman.foto_profil)}" alt="Potret ${esc(seniman.nama_lengkap)}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]" />
        <div data-fallback-gambar class="hidden h-full w-full flex items-center justify-center p-6 text-center">
          <p class="font-display text-2xl text-[#302C25] dark:text-[#F1EBDD]">${esc(seniman.nama_lengkap)}</p>
        </div>`;
    }
    return `
      <div class="relative h-full w-full flex flex-col items-center justify-center p-6 text-center bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] transition-transform duration-300 group-hover:scale-[1.02]">
        <div class="pointer-events-none absolute inset-3 border border-[#D4A943]/35"></div>
        <div class="pointer-events-none absolute inset-5 border border-[#FBF9F2]/10"></div>
        <span class="label-caps text-[#D4A943]">PERUPA ARTSPACE</span>
        <div class="mt-3 h-16 w-16 flex items-center justify-center border border-[#D4A943]/70 bg-[#29382D] dark:bg-[#171D18]">
          <span class="font-display text-2xl font-semibold tracking-[0.08em] text-[#FBF9F2] dark:text-[#F1EBDD]">${inisial}</span>
        </div>
        <div class="mt-3.5 h-[2px] w-10 bg-[#D4A943]"></div>
        <p class="mt-2.5 text-xs tracking-[0.06em] text-[#EAE5D5] dark:text-[#B8BDAA] truncate max-w-full px-4">${esc(seniman.kota)}</p>
      </div>`;
  }

  // 'potret-profil' — bingkai vertikal aspect-[4/5] pada halaman profil seniman
  if (seniman.foto_profil) {
    return `
      <img data-gambar-karya src="${esc(seniman.foto_profil)}" alt="Foto profil ${esc(seniman.nama_lengkap)}" class="h-full w-full object-cover" />
      <div data-fallback-gambar class="hidden h-full w-full flex items-center justify-center p-6 text-center">
        <p class="font-display text-2xl text-[#FBF9F2]">${esc(seniman.nama_lengkap)}</p>
      </div>`;
  }
  return `
    <div class="relative h-full w-full flex flex-col items-center justify-center p-8 text-center bg-[#29382D] dark:bg-[#171D18] text-[#FBF9F2] dark:text-[#F1EBDD]">
      <div class="pointer-events-none absolute inset-4 border border-[#D4A943]/40"></div>
      <div class="pointer-events-none absolute inset-6 border border-[#FBF9F2]/10"></div>
      <p class="label-caps text-[#D4A943]">ARSIP POTRET PERUPA</p>
      <div class="mt-5 h-24 w-24 flex items-center justify-center border-2 border-[#D4A943] bg-[#354638] dark:bg-[#20291F]">
        <span class="font-display text-4xl font-semibold tracking-[0.08em] text-[#FBF9F2] dark:text-[#F1EBDD]">${inisial}</span>
      </div>
      <div class="mt-5 h-[2px] w-12 bg-[#D4A943]"></div>
      <p class="mt-4 font-display text-xl font-medium text-[#FBF9F2] dark:text-[#F1EBDD]">${esc(seniman.nama_lengkap)}</p>
      <p class="mt-1 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">${esc(seniman.kota)}</p>
    </div>`;
}

function sinkronkanAsetGambar(imagesDir) {
  const ekstensiValid = new Set(['.png', '.jpg', '.jpeg', '.webp']);
  const fileTersedia = fs.existsSync(imagesDir)
    ? fs
        .readdirSync(imagesDir, { withFileTypes: true })
        .filter((d) => d.isFile() && ekstensiValid.has(path.extname(d.name).toLowerCase()))
        .map((d) => d.name)
        .sort((a, b) => a.localeCompare(b))
    : [];

  const setFile = new Set(fileTersedia);
  const stitchTersedia = DAFTAR_GAMBAR_STITCH.filter((f) => setFile.has(f));
  const fallbackTersedia = fileTersedia.filter(
    (f) => !/(portrait|potret)/i.test(f)
  );

  // Sinkronkan gambar karya: prioritaskan 4 gambar asli Stitch jika tersedia di public/images/
  KARYA.forEach((k, idx) => {
    if (k.gambar_stitch && setFile.has(k.gambar_stitch)) {
      k.foto_karya = `/images/${k.gambar_stitch}`;
    } else if (stitchTersedia.length > 0) {
      k.foto_karya = `/images/${stitchTersedia[idx % stitchTersedia.length]}`;
    } else if (fallbackTersedia.length > 0) {
      k.foto_karya = `/images/${fallbackTersedia[idx % fallbackTersedia.length]}`;
    } else if (fileTersedia.length > 0) {
      k.foto_karya = `/images/${fileTersedia[idx % fileTersedia.length]}`;
    } else {
      k.foto_karya = null;
    }
  });

  // Sinkronkan foto profil seniman: gunakan hanya jika file foto profil khusus seniman benar-benar tersedia,
  // selain itu null agar dirender sebagai placeholder visual editorial yang rapi (bukan gambar rusak).
  SENIMAN.forEach((s) => {
    const kandidat = [
      `seniman-${s.slug}.png`,
      `seniman-${s.slug}.jpg`,
      `seniman-${s.slug}.jpeg`,
      `seniman-${s.slug}.webp`,
      `${s.slug}.png`,
      `${s.slug}.jpg`,
      `${s.slug}.jpeg`,
      `${s.slug}.webp`,
    ];
    const cocok = kandidat.find((f) => setFile.has(f));
    s.foto_profil = cocok ? `/images/${cocok}` : null;
  });

  return {
    fileTersedia,
    stitchTersedia,
    stitchHilang: DAFTAR_GAMBAR_STITCH.filter((f) => !setFile.has(f)),
  };
}

function renderKartuKarya(k) {
  const seniman = cariSeniman(k.seniman_slug);
  const kategori = cariKategori(k.kategori_slug);
  const indeksCari = `${k.judul} ${seniman.nama_lengkap} ${k.media_bahan} ${kategori.nama} ${seniman.kota}`;

  return `
<article
  data-kartu-karya
  data-kategori="${esc(k.kategori_slug)}"
  data-cari="${esc(indeksCari)}"
  class="masonry-item reveal-on-scroll break-inside-avoid mb-5 bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden group transition-colors duration-200 hover:border-[#354638] dark:hover:border-[#D4A943]"
>
  <a href="/karya/${esc(k.slug)}/" class="block focus:outline-none">
    <div class="relative overflow-hidden bg-[#EAE5D5] dark:bg-[#20291F]">
      ${
        k.foto_karya
          ? `<img
        data-gambar-karya
        src="${esc(k.foto_karya)}"
        alt="${esc(k.judul)} oleh ${esc(seniman.nama_lengkap)}"
        loading="lazy"
        class="w-full h-auto block transition-transform duration-300 ease-out group-hover:scale-[1.03]"
      />
      <div data-fallback-gambar class="hidden aspect-[4/5] flex flex-col items-center justify-center p-6 text-center bg-[#EAE5D5] dark:bg-[#20291F]">
        <p class="font-display italic text-lg text-[#302C25] dark:text-[#F1EBDD]">${esc(k.judul)}</p>
        <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">${esc(seniman.nama_lengkap)}</p>
      </div>`
          : `<div class="aspect-[4/5] flex flex-col items-center justify-center p-6 text-center bg-[#EAE5D5] dark:bg-[#20291F]">
        <p class="font-display italic text-lg text-[#302C25] dark:text-[#F1EBDD]">${esc(k.judul)}</p>
        <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">${esc(seniman.nama_lengkap)}</p>
      </div>`
      }
    </div>

    <div class="px-4 py-3.5 bg-[#FBF9F2] dark:bg-[#293326] border-t border-[#D6D1C2]/80 dark:border-[#3A4637] transition-colors duration-200 group-hover:bg-[#EAE5D5] dark:group-hover:bg-[#354638]">
      <h3 class="font-display text-base font-semibold leading-snug text-[#302C25] dark:text-[#F1EBDD] group-hover:text-[#29382D] dark:group-hover:text-[#F1EBDD]">
        ${esc(k.judul)}
      </h3>
      <div class="mt-1 flex items-center justify-between gap-2">
        <p class="text-xs font-medium text-[#68705C] dark:text-[#B8BDAA] truncate">
          ${esc(seniman.nama_lengkap)}
        </p>
        <span class="text-[11px] font-semibold text-[#354638] dark:text-[#D4A943] opacity-0 translate-y-1 transition-all duration-200 group-hover:opacity-100 group-hover:translate-y-0 whitespace-nowrap shrink-0">
          Lihat Detail →
        </span>
      </div>
    </div>
  </a>
</article>`;
}

function renderLayout({ judul, aktif, konten, cssFile, jsFile }) {
  const navCls = (kunci) =>
    aktif === kunci
      ? 'border-[#D4A943] text-[#D4A943] font-semibold'
      : 'border-transparent text-[#FBF9F2]/90 dark:text-[#F1EBDD]/90 hover:text-[#D4A943]';

  return `<!doctype html>
<html lang="id" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>${esc(judul)}</title>
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
    <link rel="stylesheet" href="/${esc(cssFile)}" />
  </head>
  <body data-demo-prototype class="min-h-screen flex flex-col bg-[#F4F1E6] text-[#302C25] dark:bg-[#171D18] dark:text-[#F1EBDD] font-sans antialiased transition-colors duration-200 selection:bg-[#D4A943] selection:text-[#302C25]">
    <header class="sticky top-0 z-40 bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
      <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 h-16 flex items-center justify-between gap-4 lg:gap-6">
        <a href="/" class="font-display text-2xl font-semibold tracking-[0.08em] text-[#FBF9F2] dark:text-[#F1EBDD] whitespace-nowrap shrink-0 flex items-center gap-2">
          <span>ARTSPACE</span>
        </a>

        <nav class="hidden md:flex items-center gap-5 text-sm font-medium" aria-label="Navigasi Utama">
          <a href="/" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors ${navCls('beranda')}">Beranda</a>
          <a href="/jelajahi/" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors ${navCls('jelajahi')}">Jelajahi Karya</a>
          <a href="/seniman/" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors ${navCls('seniman')}">Seniman</a>
          <a href="/dasbor-seniman/" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors ${navCls('dasbor-seniman')}">Dasbor Seniman</a>
          <a href="/dasbor-admin/" class="whitespace-nowrap shrink-0 py-1 border-b-2 transition-colors ${navCls('dasbor-admin')}">Dasbor Admin</a>
        </nav>

        <form method="GET" action="/" class="hidden xl:flex items-center flex-1 max-w-xs" role="search">
          <label for="cari-navigasi" class="sr-only">Cari karya atau seniman</label>
          <div class="relative w-full flex">
            <input
              id="cari-navigasi"
              type="search"
              name="cari"
              placeholder="Cari judul karya atau seniman..."
              class="w-full bg-[#29382D] dark:bg-[#171D18] text-[#FBF9F2] dark:text-[#F1EBDD] placeholder-[#D6D1C2]/80 dark:placeholder-[#B8BDAA]/70 border border-[#77805B] dark:border-[#3A4637] rounded-l-[0.25rem] px-3.5 py-2 text-xs focus:outline-none focus:border-[#D4A943]"
            />
            <button type="submit" class="px-3.5 py-2 bg-[#D4A943] text-[#302C25] text-xs font-bold uppercase tracking-[0.08em] rounded-r-[0.25rem] hover:bg-[#FBF9F2] transition-colors whitespace-nowrap shrink-0">
              Cari
            </button>
          </div>
        </form>

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

          <a href="/masuk/" class="hidden md:inline-flex items-center justify-center px-5 py-2 bg-[#D4A943] text-[#302C25] hover:bg-[#FBF9F2] font-semibold text-xs uppercase tracking-[0.08em] rounded-[0.25rem] transition-colors whitespace-nowrap shrink-0">
            Masuk
          </a>

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

    <div data-banner-simulasi class="hidden bg-[#D4A943] text-[#302C25] border-b border-[#302C25]" role="status">
      <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-3 flex items-center justify-between gap-4 text-sm font-semibold">
        <span data-teks-simulasi></span>
        <button type="button" data-tutup-notifikasi class="text-xs uppercase tracking-[0.12em] underline underline-offset-4 shrink-0">Tutup</button>
      </div>
    </div>

    <main class="flex-1 page-enter">
      ${konten}
    </main>

    <footer class="bg-[#29382D] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-t-2 border-[#D4A943] mt-16">
      <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-14">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-10 border-b border-[#77805B]/40 dark:border-[#3A4637]">
          <div class="md:col-span-5">
            <a href="/" class="font-display text-3xl font-semibold tracking-[0.08em] text-[#FBF9F2] dark:text-[#F1EBDD]">
              ARTSPACE
            </a>
            <div class="mt-4 h-[2px] w-16 bg-[#D4A943]"></div>
            <p class="mt-4 max-w-md text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
              Platform eksplorasi visual karya seni kontemporer dan portofolio digital seniman. Dirancang untuk menemukan karya, mengenal perupa, dan mendokumentasikan perjalanan berkesenian tanpa distraksi komersial.
            </p>
          </div>

          <div class="md:col-span-3">
            <p class="label-caps text-[#D4A943]">EKSPLORASI & PRATINJAU</p>
            <ul class="mt-4 space-y-2.5 text-sm text-[#EAE5D5] dark:text-[#B8BDAA]">
              <li><a href="/" class="hover:text-[#D4A943] transition-colors">Beranda Karya</a></li>
              <li><a href="/jelajahi/" class="hover:text-[#D4A943] transition-colors">Jelajahi Karya</a></li>
              <li><a href="/seniman/" class="hover:text-[#D4A943] transition-colors">Temukan Seniman</a></li>
              <li><a href="/dasbor-seniman/" class="hover:text-[#D4A943] transition-colors">Pratinjau Dasbor Seniman</a></li>
              <li><a href="/dasbor-admin/" class="hover:text-[#D4A943] transition-colors">Pratinjau Dasbor Admin</a></li>
            </ul>
          </div>

          <div class="md:col-span-4">
            <p class="label-caps text-[#D4A943]">UNTUK SENIMAN</p>
            <p class="mt-4 text-sm text-[#EAE5D5] dark:text-[#B8BDAA] leading-relaxed">
              Bangun portofolio digital, publikasikan karya seni langsung ke katalog terbuka, dan arsipkan riwayat pameran Anda di satu ruang kurasi.
            </p>
            <div class="mt-5 flex flex-wrap gap-3">
              <a href="/daftar/" class="px-4 py-2 bg-[#D4A943] text-[#302C25] text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] hover:bg-[#FBF9F2] transition-colors">
                Daftar Seniman
              </a>
              <a href="/masuk/" class="px-4 py-2 border border-[#D4A943] text-[#D4A943] text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] hover:bg-[#D4A943] hover:text-[#302C25] transition-colors">
                Masuk Akun
              </a>
            </div>
          </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">
          <p>&copy; 2026 ARTSPACE. Platform Eksplorasi Karya Seni & Portofolio Seniman.</p>
          <p>Pratinjau Prototype Statis OJT · Kode Backend Lengkap Laravel 13 & PostgreSQL tersedia di repositori proyek.</p>
        </div>
      </div>
    </footer>

    <div data-drawer-mobile class="hidden fixed inset-0 z-50 bg-[#29382D] dark:bg-[#171D18] text-[#FBF9F2] dark:text-[#F1EBDD] flex flex-col" role="dialog" aria-modal="true" aria-label="Menu Navigasi Seluler">
      <div class="flex items-center justify-between px-5 h-16 border-b border-[#77805B]/40 dark:border-[#3A4637]">
        <a href="/" class="font-display text-2xl font-semibold tracking-[0.06em] text-[#FBF9F2]">ARTSPACE</a>
        <button type="button" data-tutup-mobile class="px-3.5 py-2 text-xs font-semibold uppercase tracking-[0.12em] border border-[#D4A943] text-[#D4A943] rounded-[0.25rem]">
          Tutup
        </button>
      </div>

      <div class="p-5 border-b border-[#77805B]/30 dark:border-[#3A4637]">
        <form method="GET" action="/" class="flex gap-2">
          <input
            type="search"
            name="cari"
            placeholder="Cari judul karya atau seniman..."
            class="flex-1 bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm"
          />
          <button type="submit" class="px-4 py-2.5 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
            Cari
          </button>
        </form>
      </div>

      <nav class="flex-1 px-6 py-8 flex flex-col gap-4 overflow-y-auto">
        <a href="/" class="font-display text-2xl text-[#FBF9F2] hover:text-[#D4A943]">Beranda</a>
        <a href="/jelajahi/" class="font-display text-2xl text-[#FBF9F2] hover:text-[#D4A943]">Jelajahi Karya</a>
        <a href="/seniman/" class="font-display text-2xl text-[#FBF9F2] hover:text-[#D4A943]">Seniman</a>
        <a href="/dasbor-seniman/" class="font-display text-2xl text-[#D4A943]">Dasbor Seniman</a>
        <a href="/dasbor-admin/" class="font-display text-2xl text-[#D4A943]">Dasbor Admin</a>
      </nav>

      <div class="p-6 border-t border-[#77805B]/40 dark:border-[#3A4637] space-y-3">
        <button type="button" data-sakelar-tema class="w-full py-2.5 text-xs font-semibold uppercase tracking-[0.12em] border border-[#D6D1C2]/50 text-[#FBF9F2] rounded-[0.25rem]">
          Ganti Tema Gelap / Terang
        </button>
        <div class="grid grid-cols-2 gap-2.5">
          <a href="/masuk/" class="block text-center py-3 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.12em] rounded-[0.25rem]">Masuk</a>
          <a href="/daftar/" class="block text-center py-3 border border-[#D4A943] text-[#D4A943] font-semibold text-xs uppercase tracking-[0.12em] rounded-[0.25rem]">Daftar</a>
        </div>
      </div>
    </div>

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
          <img data-gambar-zoom src="" alt="" class="max-h-[78vh] w-auto object-contain" />
        </div>
      </div>
    </div>

    <script type="module" src="/${esc(jsFile)}"></script>
  </body>
</html>`;
}

function halamanBeranda() {
  const tombolKat = [
    `<button type="button" data-filter-masonry="semua" aria-pressed="true" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] border transition-colors whitespace-nowrap shrink-0 bg-[#354638] text-[#FBF9F2] border-[#354638] dark:bg-[#D4A943] dark:text-[#302C25] dark:border-[#D4A943]">Semua Karya</button>`,
    ...KATEGORI.map(
      (kat) =>
        `<button type="button" data-filter-masonry="${esc(kat.slug)}" aria-pressed="false" class="px-3.5 py-2 text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] border transition-colors whitespace-nowrap shrink-0 bg-[#FBF9F2] text-[#302C25] border-[#D6D1C2] hover:border-[#354638] dark:bg-[#293326] dark:text-[#F1EBDD] dark:border-[#3A4637] dark:hover:border-[#D4A943]">${esc(kat.nama)}</button>`
    ),
  ].join('\n');

  const senimanCocokHtml = SENIMAN.map(
    (s) => `
    <a data-seniman-cocok-item data-cari="${esc(`${s.nama_lengkap} ${s.kota} ${s.disiplin}`)}" href="/seniman/${esc(s.slug)}/" class="hidden flex items-center gap-4 p-3.5 bg-[#29382D] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] hover:border-[#D4A943] transition-colors">
      ${renderFotoSeniman(s, 'avatar-md')}
      <div class="min-w-0">
        <p class="font-display text-base font-semibold text-[#FBF9F2] truncate">${esc(s.nama_lengkap)}</p>
        <p class="text-xs text-[#D6D1C2] dark:text-[#B8BDAA] truncate">${esc(s.kota)} · ${esc(s.disiplin)}</p>
      </div>
    </a>`
  ).join('\n');

  return `
  <section class="bg-[#EAE5D5] dark:bg-[#20291F] border-b border-[#D6D1C2] dark:border-[#3A4637]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-6">
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5">
        <div>
          <div class="flex items-center gap-3">
            <span class="inline-block h-[2px] w-8 bg-[#D4A943]"></span>
            <p class="label-caps text-[#354638] dark:text-[#A5B18A]">EKSPLORASI VISUAL KARYA SENI</p>
          </div>
          <h1 data-judul-beranda class="mt-2 font-display text-3xl sm:text-4xl font-semibold tracking-tight text-[#302C25] dark:text-[#F1EBDD] kinetic-heading">
            Temukan Karya & Perupa Kontemporer
          </h1>
        </div>

        <form data-form-cari-karya method="GET" action="/" class="flex xl:hidden w-full sm:max-w-md gap-2">
          <input
            type="search"
            name="cari"
            placeholder="Cari judul karya atau nama seniman..."
            class="flex-1 bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
          />
          <button type="submit" class="px-4 py-2 bg-[#354638] dark:bg-[#D4A943] text-[#FBF9F2] dark:text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem]">
            Cari
          </button>
        </form>

        <div class="flex flex-wrap items-center gap-2" role="group" aria-label="Saring kategori karya">
          ${tombolKat}
        </div>
      </div>
    </div>
  </section>

  <section data-panel-seniman-cocok class="hidden max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-8">
    <div class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] rounded-[0.25rem] p-6 border border-[#29382D] dark:border-[#3A4637]">
      <div class="flex items-center justify-between gap-4 mb-5">
        <p class="label-caps text-[#D4A943]">SENIMAN YANG RELEVAN</p>
        <a href="/seniman/" class="text-xs font-semibold text-[#D4A943] underline underline-offset-4">Lihat di Direktori Seniman</a>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        ${senimanCocokHtml}
      </div>
    </div>
  </section>

  <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-8" aria-label="Galeri Masonry Karya Seni">
    <div data-info-pencarian class="hidden mb-6 flex items-center justify-between gap-4 text-sm text-[#68705C] dark:text-[#B8BDAA]">
      <p class="tabular-nums">Menampilkan <strong data-jumlah-karya-tampil class="text-[#302C25] dark:text-[#F1EBDD]">${KARYA.length}</strong> karya cocok.</p>
      <a href="/" data-reset-filter class="text-xs font-semibold uppercase tracking-[0.1em] text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
        Atur Ulang Filter
      </a>
    </div>

    <div data-masonry-grid class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-5">
      ${KARYA.map(renderKartuKarya).join('\n')}
    </div>

    <div data-masonry-kosong class="hidden bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-12 text-center">
      <p class="label-caps text-[#354638] dark:text-[#D4A943]">PENCARIAN KOSONG</p>
      <h2 class="mt-3 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Belum ada karya yang cocok</h2>
      <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA] max-w-md mx-auto">Coba kata kunci atau kategori lain untuk melanjutkan eksplorasi visual.</p>
      <button type="button" data-reset-filter class="mt-6 inline-flex px-6 py-2.5 bg-[#D4A943] text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#354638] hover:text-[#FBF9F2] transition-colors">
        Tampilkan Semua Karya
      </button>
    </div>

    <div class="mt-14 bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-2 border-[#29382D] dark:border-[#3A4637] rounded-[0.25rem] p-8 md:p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
      <div class="max-w-2xl">
        <p class="label-caps text-[#D4A943]">PORTOFOLIO & RIWAYAT PAMERAN</p>
        <h2 class="mt-2 font-display text-2xl sm:text-3xl font-medium">Kenali Latar Belakang & Perjalanan Seniman di Balik Setiap Karya</h2>
        <p class="mt-2 text-sm text-[#EAE5D5] dark:text-[#B8BDAA] tabular-nums">
          ${SENIMAN.length} seniman tergabung · ${KARYA.length} karya terpublikasi terbuka untuk dieksplorasi tanpa login.
        </p>
      </div>
      <div class="flex flex-wrap gap-3 shrink-0">
        <a href="/seniman/" class="px-6 py-3 bg-[#D4A943] text-[#302C25] text-xs font-bold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#FBF9F2] transition-colors whitespace-nowrap">
          Temukan Seniman
        </a>
        <a href="/daftar/" class="px-6 py-3 border border-[#D4A943] text-[#D4A943] text-xs font-bold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#D4A943] hover:text-[#302C25] transition-colors whitespace-nowrap">
          Gabung sebagai Seniman
        </a>
      </div>
    </div>
  </section>`;
}

function halamanJelajahi() {
  const opsiKat = KATEGORI.map((k) => `<option value="${esc(k.slug)}">${esc(k.nama)}</option>`).join('\n');

  return `
  <section class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10">
      <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
          <p class="label-caps text-[#D4A943]">KATALOG PUBLIK TERBIT</p>
          <h1 class="mt-2 font-display text-3xl sm:text-4xl font-semibold kinetic-heading">Jelajahi Karya Seni</h1>
          <p class="mt-2 max-w-2xl text-sm text-[#EAE5D5] dark:text-[#B8BDAA]">
            Seluruh karya yang diterbitkan seniman tampil secara terbuka. Klik karya mana saja untuk membuka halaman detail dua kolom berisi deskripsi, media, tahun pembuatan, dan profil senimannya.
          </p>
        </div>

        <form data-form-cari-karya method="GET" action="/jelajahi/" class="flex flex-col sm:flex-row gap-2.5 w-full lg:w-auto">
          <input
            type="search"
            name="cari"
            placeholder="Cari judul karya atau seniman..."
            class="sm:w-64 bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm"
          />
          <select data-select-kategori name="kategori" class="bg-[#FBF9F2] dark:bg-[#293326] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">
            <option value="semua">Semua Kategori</option>
            ${opsiKat}
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
        Menampilkan <strong data-jumlah-karya-tampil class="text-[#302C25] dark:text-[#F1EBDD]">${KARYA.length}</strong> karya terbit
      </p>
      <button type="button" data-reset-filter class="text-xs font-semibold uppercase tracking-[0.1em] text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
        Atur Ulang Filter
      </button>
    </div>

    <div data-masonry-grid class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-5">
      ${KARYA.map(renderKartuKarya).join('\n')}
    </div>

    <div data-masonry-kosong class="hidden bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-12 text-center">
      <h2 class="font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Tidak ada karya ditemukan</h2>
      <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA]">Ubah kata kunci pencarian atau pilih kategori lain.</p>
      <button type="button" data-reset-filter class="mt-6 inline-flex px-6 py-2.5 bg-[#D4A943] text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem]">
        Lihat Semua Karya
      </button>
    </div>
  </section>`;
}

function halamanDetailKarya(karya) {
  const seniman = cariSeniman(karya.seniman_slug);
  const kategori = cariKategori(karya.kategori_slug);
  const harga = formatRupiah(karya.harga_opsional);

  return `
  <section class="max-w-[1320px] mx-auto px-4 sm:px-6 lg:px-10 py-8 lg:py-12">
    <div class="mb-6 flex items-center justify-between gap-4">
      <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-[#EAE5D5] dark:bg-[#20291F] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] text-xs font-semibold uppercase tracking-[0.1em] text-[#302C25] dark:text-[#F1EBDD] hover:bg-[#354638] hover:text-[#FBF9F2] dark:hover:bg-[#354638] transition-colors">
        ← Kembali ke Galeri
      </a>
      <span class="label-caps text-[#68705C] dark:text-[#B8BDAA]">DETAIL KARYA SENI</span>
    </div>

    <article class="grid grid-cols-1 lg:grid-cols-12 bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden detail-image-reveal">
      <div class="lg:col-span-7 bg-[#EAE5D5] dark:bg-[#20291F] p-5 sm:p-8 lg:p-10 flex flex-col justify-between border-b lg:border-b-0 lg:border-r border-[#D6D1C2] dark:border-[#3A4637]">
        <div class="flex-1 flex items-center justify-center">
          ${
            karya.foto_karya
              ? `<img
            data-gambar-karya
            src="${esc(karya.foto_karya)}"
            alt="${esc(karya.judul)} oleh ${esc(seniman.nama_lengkap)}"
            class="max-h-[78vh] w-auto max-w-full object-contain block"
          />
          <div data-fallback-gambar class="hidden w-full aspect-[4/5] flex flex-col items-center justify-center bg-[#F4F1E6] dark:bg-[#171D18] p-8 text-center">
            <p class="font-display italic text-2xl text-[#302C25] dark:text-[#F1EBDD]">${esc(karya.judul)}</p>
            <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA]">${esc(seniman.nama_lengkap)}</p>
          </div>`
              : `<div class="w-full aspect-[4/5] flex flex-col items-center justify-center bg-[#F4F1E6] dark:bg-[#171D18] p-8 text-center">
            <p class="font-display italic text-2xl text-[#302C25] dark:text-[#F1EBDD]">${esc(karya.judul)}</p>
            <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA]">${esc(seniman.nama_lengkap)}</p>
          </div>`
          }
        </div>

        <div class="mt-6 pt-4 border-t border-[#D6D1C2] dark:border-[#3A4637] flex flex-wrap items-center justify-between gap-3">
          <p class="text-xs text-[#68705C] dark:text-[#B8BDAA]">
            Dokumentasi karya — proporsi asli dipertahankan tanpa pemotongan.
          </p>
          ${
            karya.foto_karya
              ? `<button
            type="button"
            data-pemicu-zoom
            data-zoom-src="${esc(karya.foto_karya)}"
            data-zoom-judul="${esc(karya.judul)} — ${esc(seniman.nama_lengkap)} (${karya.tahun_pembuatan})"
            class="px-4 py-2 bg-[#354638] dark:bg-[#D4A943] text-[#FBF9F2] dark:text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#29382D] dark:hover:bg-[#F1EBDD] transition-colors whitespace-nowrap"
          >
            Perbesar Gambar
          </button>`
              : ''
          }
        </div>
      </div>

      <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 flex flex-col justify-between space-y-8">
        <div class="space-y-6">
          <div class="flex items-center justify-between gap-4 pb-5 border-b border-[#D6D1C2] dark:border-[#3A4637]">
            <a href="/seniman/${esc(seniman.slug)}/" class="flex items-center gap-3.5 group min-w-0">
              ${renderFotoSeniman(seniman, 'avatar-sm')}
              <div class="min-w-0">
                <p class="label-caps text-[#68705C] dark:text-[#B8BDAA]">SENIMAN</p>
                <p class="font-display text-lg font-semibold text-[#302C25] dark:text-[#F1EBDD] group-hover:text-[#354638] dark:group-hover:text-[#D4A943] truncate transition-colors">
                  ${esc(seniman.nama_lengkap)}
                </p>
              </div>
            </a>
            <a href="/seniman/${esc(seniman.slug)}/" class="px-3.5 py-2 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] hover:bg-[#354638] hover:text-[#FBF9F2] dark:hover:bg-[#A5B18A] dark:hover:text-[#171D18] text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] transition-colors whitespace-nowrap shrink-0">
              Profil
            </a>
          </div>

          <div>
            <span class="inline-block px-2.5 py-1 bg-[#D4A943] text-[#302C25] label-caps rounded-[0.125rem]">
              ${esc(kategori.nama)}
            </span>
            <h1 class="mt-3 font-display text-3xl sm:text-4xl font-semibold leading-tight text-[#302C25] dark:text-[#F1EBDD] kinetic-heading">
              ${esc(karya.judul)}
            </h1>
          </div>

          <div class="space-y-5">
            <p class="text-base leading-relaxed text-[#302C25] dark:text-[#F1EBDD]">
              ${esc(karya.deskripsi)}
            </p>

            <dl class="divide-y divide-[#D6D1C2] dark:divide-[#3A4637] border-y border-[#D6D1C2] dark:border-[#3A4637] text-sm">
              <div class="py-3 grid grid-cols-12 gap-3">
                <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">TAHUN PEMBUATAN</dt>
                <dd class="col-span-7 font-medium text-[#302C25] dark:text-[#F1EBDD] tabular-nums">${karya.tahun_pembuatan}</dd>
              </div>
              <div class="py-3 grid grid-cols-12 gap-3">
                <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">MEDIA / BAHAN</dt>
                <dd class="col-span-7 text-[#302C25] dark:text-[#F1EBDD] leading-relaxed">${esc(karya.media_bahan)}</dd>
              </div>
              <div class="py-3 grid grid-cols-12 gap-3">
                <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">KATEGORI</dt>
                <dd class="col-span-7 text-[#302C25] dark:text-[#F1EBDD]">${esc(kategori.nama)}</dd>
              </div>
              ${
                karya.dimensi
                  ? `<div class="py-3 grid grid-cols-12 gap-3">
                <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">DIMENSI</dt>
                <dd class="col-span-7 text-[#302C25] dark:text-[#F1EBDD] tabular-nums">${esc(karya.dimensi)}</dd>
              </div>`
                  : ''
              }
              ${
                karya.informasi_tambahan
                  ? `<div class="py-3 grid grid-cols-12 gap-3">
                <dt class="col-span-5 label-caps text-[#68705C] dark:text-[#B8BDAA] pt-0.5">INFO TAMBAHAN</dt>
                <dd class="col-span-7 text-[#302C25] dark:text-[#F1EBDD] leading-relaxed">${esc(karya.informasi_tambahan)}</dd>
              </div>`
                  : ''
              }
            </dl>
          </div>

          ${
            harga
              ? `<div class="bg-[#EAE5D5] dark:bg-[#20291F] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-4">
            <p class="label-caps text-[#354638] dark:text-[#D4A943]">INFORMASI HARGA (OPSIONAL)</p>
            <p class="mt-1.5 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD] tabular-nums">
              ${esc(harga)}
            </p>
            <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">
              Dicantumkan sebagai informasi referensi oleh seniman. ARTSPACE tidak menyediakan fitur pembelian atau transaksi.
            </p>
          </div>`
              : ''
          }
        </div>

        <div class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] rounded-[0.25rem] p-5 border border-[#29382D] dark:border-[#3A4637]">
          <p class="label-caps text-[#D4A943]">TENTANG SENIMAN</p>
          <div class="mt-3 flex items-start gap-4">
            ${renderFotoSeniman(seniman, 'avatar-md')}
            <div class="min-w-0">
              <h2 class="font-display text-lg font-semibold text-[#FBF9F2] dark:text-[#F1EBDD]">${esc(seniman.nama_lengkap)}</h2>
              <p class="text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">${esc(seniman.kota)} · ${esc(seniman.disiplin)}</p>
            </div>
          </div>
          <p class="mt-3 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
            ${esc(seniman.biografi_singkat)}
          </p>
          <a href="/seniman/${esc(seniman.slug)}/" class="mt-4 inline-flex items-center justify-center w-full py-2.5 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#FBF9F2] transition-colors">
            Lihat Profil & Riwayat Pameran Seniman
          </a>
        </div>
      </div>
    </article>
  </section>`;
}

function halamanDirektoriSeniman() {
  const kartuSeniman = SENIMAN.map((s) => {
    const jumlahKarya = KARYA.filter((k) => k.seniman_slug === s.slug).length;
    return `
    <article data-kartu-seniman data-cari="${esc(`${s.nama_lengkap} ${s.kota} ${s.disiplin} ${s.biografi_singkat}`)}" class="reveal-on-scroll flex flex-col bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden hover:border-[#354638] dark:hover:border-[#D4A943] transition-colors">
      <a href="/seniman/${esc(s.slug)}/" class="block bg-[#EAE5D5] dark:bg-[#20291F] aspect-[4/3] overflow-hidden group">
        ${renderFotoSeniman(s, 'kartu-direktori')}
      </a>

      <div class="flex flex-1 flex-col p-6">
        <div class="flex items-center justify-between gap-3">
          <p class="label-caps text-[#354638] dark:text-[#A5B18A]">${esc(s.kota)}</p>
          <span class="px-2.5 py-0.5 bg-[#EAE5D5] dark:bg-[#20291F] border border-[#D6D1C2] dark:border-[#3A4637] text-xs font-semibold text-[#302C25] dark:text-[#F1EBDD] tabular-nums">
            ${jumlahKarya} Karya
          </span>
        </div>

        <h2 class="mt-2.5 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">
          <a href="/seniman/${esc(s.slug)}/" class="hover:text-[#354638] dark:hover:text-[#D4A943] transition-colors">
            ${esc(s.nama_lengkap)}
          </a>
        </h2>
        <p class="mt-1 text-xs font-medium text-[#68705C] dark:text-[#B8BDAA]">${esc(s.disiplin)}</p>

        <p class="mt-4 text-sm leading-relaxed text-[#302C25] dark:text-[#F1EBDD]/90 flex-1">
          ${esc(s.biografi_singkat)}
        </p>

        <div class="mt-6 pt-4 border-t border-[#D6D1C2] dark:border-[#3A4637]">
          <a href="/seniman/${esc(s.slug)}/" class="inline-flex w-full items-center justify-center py-2.5 bg-[#354638] dark:bg-[#D4A943] text-[#FBF9F2] dark:text-[#302C25] text-xs font-semibold uppercase tracking-[0.1em] rounded-[0.25rem] hover:bg-[#29382D] dark:hover:bg-[#F1EBDD] transition-colors">
            Lihat Profil & Portofolio
          </a>
        </div>
      </div>
    </article>`;
  }).join('\n');

  return `
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

        <form data-form-cari-seniman method="GET" action="/seniman/" class="flex w-full lg:w-auto gap-2.5">
          <input
            type="search"
            name="cari"
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

  <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
    <div data-info-cari-seniman class="hidden mb-8 flex items-center justify-between gap-4 pb-4 border-b border-[#D6D1C2] dark:border-[#3A4637] text-sm">
      <p class="text-[#68705C] dark:text-[#B8BDAA] tabular-nums">
        Ditemukan <strong data-jumlah-seniman-tampil class="text-[#302C25] dark:text-[#F1EBDD]">${SENIMAN.length}</strong> seniman untuk “<span data-label-cari-seniman></span>”.
      </p>
      <button type="button" data-reset-seniman class="text-xs font-semibold uppercase tracking-[0.1em] text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
        Tampilkan Semua
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
      ${kartuSeniman}
    </div>

    <div data-seniman-kosong class="hidden bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-12 text-center">
      <h2 class="font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Seniman tidak ditemukan</h2>
      <p class="mt-2 text-sm text-[#68705C] dark:text-[#B8BDAA]">Coba cari dengan nama atau kota lain.</p>
    </div>
  </section>`;
}

function halamanProfilSeniman(seniman) {
  const karyaSeniman = KARYA.filter((k) => k.seniman_slug === seniman.slug);

  const pameranHtml = seniman.pameran
    .map(
      (p) => `
    <article class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6">
      <div class="flex items-center justify-between gap-2">
        <span class="px-2.5 py-0.5 bg-[#D4A943] text-[#302C25] text-xs font-bold tabular-nums rounded-[0.125rem]">${p.tahun}</span>
        <span class="text-xs text-[#68705C] dark:text-[#B8BDAA] truncate">${esc(p.lokasi)}</span>
      </div>
      <h3 class="mt-3 font-display text-xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">${esc(p.nama_pameran)}</h3>
      <p class="mt-2 text-sm leading-relaxed text-[#68705C] dark:text-[#B8BDAA]">${esc(p.deskripsi)}</p>
    </article>`
    )
    .join('\n');

  return `
  <section class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12 lg:py-16">
      <div class="mb-6">
        <a href="/seniman/" class="text-xs font-semibold uppercase tracking-[0.12em] text-[#D4A943] hover:underline">
          ← Kembali ke Direktori Seniman
        </a>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <div class="lg:col-span-4">
          <div class="bg-[#29382D] dark:bg-[#171D18] border border-[#D4A943]/60 overflow-hidden aspect-[4/5]">
            ${renderFotoSeniman(seniman, 'potret-profil')}
          </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
          <div>
            <p class="label-caps text-[#D4A943]">PORTOFOLIO EDITORIAL SENIMAN</p>
            <h1 class="mt-2 font-display text-4xl sm:text-5xl font-semibold kinetic-heading">${esc(seniman.nama_lengkap)}</h1>
            <p class="mt-2 text-sm text-[#EAE5D5] dark:text-[#B8BDAA]">
              ${esc(seniman.kota)} · ${esc(seniman.disiplin)} · <span class="tabular-nums">${karyaSeniman.length} Karya Terbit</span>
            </p>
            <div class="mt-5 h-[2px] w-16 bg-[#D4A943]"></div>
          </div>

          <p class="text-base lg:text-lg leading-relaxed text-[#FBF9F2] dark:text-[#F1EBDD] max-w-3xl">
            ${esc(seniman.biografi)}
          </p>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-4 border-t border-[#77805B]/40 dark:border-[#3A4637]">
            <div class="bg-[#29382D] dark:bg-[#293326] p-5 rounded-[0.25rem] border border-[#77805B]/30 dark:border-[#3A4637]">
              <p class="label-caps text-[#D4A943]">LATAR BELAKANG</p>
              <p class="mt-2.5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">${esc(seniman.latar_belakang)}</p>
            </div>
            <div class="bg-[#29382D] dark:bg-[#293326] p-5 rounded-[0.25rem] border border-[#77805B]/30 dark:border-[#3A4637]">
              <p class="label-caps text-[#D4A943]">PERJALANAN BERKESENIAN</p>
              <p class="mt-2.5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">${esc(seniman.perjalanan_berkesenian)}</p>
            </div>
            <div class="bg-[#29382D] dark:bg-[#293326] p-5 rounded-[0.25rem] border border-[#77805B]/30 dark:border-[#3A4637]">
              <p class="label-caps text-[#D4A943]">PENGALAMAN</p>
              <p class="mt-2.5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">${esc(seniman.pengalaman)}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-[#EAE5D5] dark:bg-[#20291F] border-b border-[#D6D1C2] dark:border-[#3A4637]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
      <div class="flex items-center gap-3 mb-6">
        <span class="h-[2px] w-10 bg-[#D4A943]"></span>
        <h2 class="font-display text-2xl sm:text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Riwayat Pameran</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        ${pameranHtml}
      </div>
    </div>
  </section>

  <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-12">
    <div class="flex items-end justify-between gap-4 pb-6 mb-8 border-b border-[#D6D1C2] dark:border-[#3A4637]">
      <div>
        <p class="label-caps text-[#354638] dark:text-[#A5B18A]">PORTOFOLIO KARYA</p>
        <h2 class="mt-1.5 font-display text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">
          Galeri Karya ${esc(seniman.nama_lengkap)}
        </h2>
      </div>
      <span class="text-xs font-semibold text-[#68705C] dark:text-[#B8BDAA] tabular-nums">
        ${karyaSeniman.length} Karya Terbit
      </span>
    </div>

    <div class="columns-1 sm:columns-2 lg:columns-3 gap-5">
      ${karyaSeniman.map(renderKartuKarya).join('\n')}
    </div>
  </section>`;
}

function halamanMasuk() {
  return `
  <section class="max-w-[1160px] mx-auto px-4 sm:px-6 lg:px-10 py-12 lg:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden">
      <div class="lg:col-span-5 bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] p-8 lg:p-10 flex flex-col justify-between">
        <div>
          <p class="label-caps text-[#D4A943]">AKSES AKUN ARTSPACE</p>
          <h1 class="mt-3 font-display text-3xl sm:text-4xl font-semibold leading-tight">
            Masuk ke Ruang Portofolio & Moderasi
          </h1>
          <div class="mt-5 h-[2px] w-14 bg-[#D4A943]"></div>
          <p class="mt-5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
            Masuk sebagai Seniman untuk mengelola profil, karya seni, dan riwayat pameran, atau sebagai Admin untuk memantau konten dan laporan sistem. Pengunjung publik tetap bebas menjelajahi karya tanpa masuk.
          </p>
        </div>

        <div class="mt-8 bg-[#29382D] dark:bg-[#293326] border border-[#D4A943]/50 rounded-[0.25rem] p-5 space-y-3">
          <p class="label-caps text-[#D4A943]">SIMULASI PRATINJAU STATIS</p>
          <div class="text-xs space-y-2 text-[#EAE5D5] dark:text-[#B8BDAA]">
            <div>
              <p class="font-semibold text-[#FBF9F2]">Seniman (Baskoro Wijaya)</p>
              <p class="tabular-nums">Surel: <code class="text-[#D4A943]">baskoro@artspace.id</code> · Sandi: <code class="text-[#D4A943]">artspace123</code></p>
            </div>
            <div class="pt-2 border-t border-[#77805B]/30">
              <p class="font-semibold text-[#FBF9F2]">Administrator Sistem</p>
              <p class="tabular-nums">Surel: <code class="text-[#D4A943]">admin@artspace.id</code> · Sandi: <code class="text-[#D4A943]">admin123</code></p>
            </div>
            <p class="pt-2 border-t border-[#77805B]/30 text-[11px] text-[#D6D1C2]">
              Catatan: Versi Vercel ini adalah simulasi demonstrasi antarmuka tanpa autentikasi server/database.
            </p>
          </div>
        </div>
      </div>

      <div class="lg:col-span-7 bg-[#FBF9F2] dark:bg-[#293326] p-8 lg:p-12">
        <p class="label-caps text-[#354638] dark:text-[#A5B18A]">AUTENTIKASI PENGGUNA</p>
        <h2 class="mt-2 font-display text-2xl sm:text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Masuk ke Akun Anda</h2>

        <form data-demo-masuk class="mt-7 space-y-5">
          <div>
            <label for="surel" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">ALAMAT SUREL *</label>
            <input
              id="surel"
              name="surel"
              type="email"
              required
              value="baskoro@artspace.id"
              placeholder="nama@artspace.id"
              class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
            />
          </div>

          <div>
            <label for="kata_sandi" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">KATA SANDI *</label>
            <input
              id="kata_sandi"
              name="kata_sandi"
              type="password"
              required
              value="artspace123"
              placeholder="Masukkan kata sandi Anda"
              class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]"
            />
          </div>

          <button type="submit" class="w-full py-3.5 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
            Masuk ke ARTSPACE (Simulasi)
          </button>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
            <a href="/dasbor-seniman/" class="text-center py-2.5 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] hover:bg-[#354638] hover:text-[#FBF9F2] text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] transition-colors">
              Buka Pratinjau Dasbor Seniman
            </a>
            <a href="/dasbor-admin/" class="text-center py-2.5 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] hover:bg-[#354638] hover:text-[#FBF9F2] text-xs font-semibold uppercase tracking-[0.08em] rounded-[0.25rem] transition-colors">
              Buka Pratinjau Dasbor Admin
            </a>
          </div>
        </form>

        <div class="mt-8 pt-6 border-t border-[#D6D1C2] dark:border-[#3A4637] flex flex-wrap items-center justify-between gap-3 text-sm">
          <span class="text-[#68705C] dark:text-[#B8BDAA]">Belum memiliki akun seniman?</span>
          <a href="/daftar/" class="font-semibold text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
            Daftar sebagai Seniman →
          </a>
        </div>
      </div>
    </div>
  </section>`;
}

function halamanDaftar() {
  return `
  <section class="max-w-[1160px] mx-auto px-4 sm:px-6 lg:px-10 py-12 lg:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] overflow-hidden">
      <div class="lg:col-span-5 bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] p-8 lg:p-10 flex flex-col justify-between">
        <div>
          <p class="label-caps text-[#D4A943]">PENDAFTARAN SENIMAN</p>
          <h1 class="mt-3 font-display text-3xl sm:text-4xl font-semibold leading-tight">
            Bangun Portofolio Digital Karya Seni Anda
          </h1>
          <div class="mt-5 h-[2px] w-14 bg-[#D4A943]"></div>
          <p class="mt-5 text-sm leading-relaxed text-[#EAE5D5] dark:text-[#B8BDAA]">
            Setelah mendaftar, Anda dapat melengkapi biografi, mendokumentasikan riwayat pameran, serta menerbitkan karya langsung ke galeri publik ARTSPACE.
          </p>
        </div>

        <div class="mt-8 pt-6 border-t border-[#77805B]/40 dark:border-[#3A4637] space-y-2 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">
          <p>• Karya yang Anda unggah langsung berstatus <strong class="text-[#D4A943]">TERBIT</strong>.</p>
          <p>• Riwayat pameran tampil terpadu di halaman profil Anda.</p>
          <p>• Pendaftaran publik khusus untuk akun Seniman.</p>
          <p class="pt-2 text-[11px]">• Catatan: Formulir pada pratinjau Vercel ini bersifat simulasi antarmuka (belum menyimpan ke database).</p>
        </div>
      </div>

      <div class="lg:col-span-7 bg-[#FBF9F2] dark:bg-[#293326] p-8 lg:p-12">
        <p class="label-caps text-[#354638] dark:text-[#A5B18A]">AKUN BARU SENIMAN</p>
        <h2 class="mt-2 font-display text-2xl sm:text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Daftar Akun Seniman</h2>

        <form data-demo-daftar class="mt-7 space-y-5">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
              <label for="nama_lengkap" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">NAMA LENGKAP SENIMAN *</label>
              <input id="nama_lengkap" name="nama_lengkap" type="text" required placeholder="Contoh: Kirana Larasati" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]" />
            </div>

            <div>
              <label for="kota" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">KOTA DOMISILI *</label>
              <input id="kota" name="kota" type="text" required placeholder="Contoh: Bandung" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]" />
            </div>

            <div>
              <label for="disiplin" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">DISIPLIN BERKESENIAN *</label>
              <input id="disiplin" name="disiplin" type="text" required placeholder="Lukisan, Patung, Fotografi..." class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]" />
            </div>

            <div class="sm:col-span-2">
              <label for="surel" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">ALAMAT SUREL *</label>
              <input id="surel" name="surel" type="email" required placeholder="seniman@contoh.id" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]" />
            </div>

            <div>
              <label for="kata_sandi" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">KATA SANDI (MIN. 8 KARAKTER) *</label>
              <input id="kata_sandi" name="kata_sandi" type="password" required minlength="8" placeholder="Minimal 8 karakter" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]" />
            </div>

            <div>
              <label for="kata_sandi_confirmation" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-2">KONFIRMASI KATA SANDI *</label>
              <input id="kata_sandi_confirmation" name="kata_sandi_confirmation" type="password" required minlength="8" placeholder="Ulangi kata sandi" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-4 py-3 text-sm focus:outline-none focus:border-[#354638] dark:focus:border-[#D4A943]" />
            </div>
          </div>

          <button type="submit" class="w-full py-3.5 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
            Buat Akun Seniman (Simulasi)
          </button>
        </form>

        <div class="mt-8 pt-6 border-t border-[#D6D1C2] dark:border-[#3A4637] flex flex-wrap items-center justify-between gap-3 text-sm">
          <span class="text-[#68705C] dark:text-[#B8BDAA]">Sudah memiliki akun terdaftar?</span>
          <a href="/masuk/" class="font-semibold text-[#354638] dark:text-[#D4A943] underline underline-offset-4">
            Masuk di Sini →
          </a>
        </div>
      </div>
    </div>
  </section>`;
}

function halamanDasborSeniman() {
  const seniman = SENIMAN[0]; // Baskoro Wijaya sebagai pratinjau demo
  const karyaSaya = KARYA.filter((k) => k.seniman_slug === seniman.slug);
  const opsiKat = KATEGORI.map((k) => `<option value="${k.id}">${esc(k.nama)}</option>`).join('\n');

  const daftarKaryaHtml = karyaSaya
    .map((k) => {
      const kat = cariKategori(k.kategori_slug);
      return `
      <article class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-5">
        <div class="flex flex-col sm:flex-row gap-5">
          ${
            k.foto_karya
              ? `<img src="${esc(k.foto_karya)}" alt="${esc(k.judul)}" class="w-full sm:w-28 h-36 object-cover bg-[#EAE5D5] dark:bg-[#20291F] shrink-0" />`
              : `<div class="w-full sm:w-28 h-36 flex items-center justify-center p-2 text-center bg-[#EAE5D5] dark:bg-[#20291F] shrink-0 text-xs font-display italic text-[#302C25] dark:text-[#F1EBDD]">${esc(k.judul)}</div>`
          }
          <div class="flex-1 min-w-0">
            <div class="flex flex-wrap items-center justify-between gap-2">
              <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.12em] rounded-[0.125rem] bg-[#354638] text-[#FBF9F2] dark:bg-[#A5B18A] dark:text-[#171D18]">${k.status}</span>
              <span class="text-xs text-[#68705C] dark:text-[#B8BDAA] tabular-nums">${k.tahun_pembuatan} · ${esc(kat.nama)}</span>
            </div>
            <h3 class="mt-2 font-display text-xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">
              <a href="/karya/${esc(k.slug)}/" class="hover:underline">${esc(k.judul)}</a>
            </h3>
            <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">${esc(k.media_bahan)}</p>
            <p class="mt-2 text-sm text-[#302C25] dark:text-[#F1EBDD]/90 line-clamp-2">${esc(k.deskripsi)}</p>

            <div class="mt-4 flex flex-wrap items-center gap-2.5">
              <button type="button" data-buka-edit="edit-karya-${k.id}" class="px-3.5 py-1.5 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] text-xs font-semibold rounded-[0.25rem] hover:bg-[#354638] hover:text-[#FBF9F2]">
                Ubah Karya
              </button>
              <form data-demo-aksi="Mode Pratinjau Statis: Penghapusan karya nyata aktif pada backend Laravel 13 & PostgreSQL.">
                <button type="submit" class="px-3.5 py-1.5 border border-[#BA1A1A] text-[#BA1A1A] dark:text-[#FFDAD6] text-xs font-semibold rounded-[0.25rem] hover:bg-[#BA1A1A] hover:text-[#FBF9F2]">
                  Hapus
                </button>
              </form>
            </div>
          </div>
        </div>

        <form id="edit-karya-${k.id}" data-demo-aksi="Mode Pratinjau Statis: Perubahan karya memerlukan backend Laravel 13 & PostgreSQL agar tersimpan permanen." class="hidden mt-5 pt-5 border-t border-[#D6D1C2] dark:border-[#3A4637] grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div class="sm:col-span-2">
            <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">JUDUL *</label>
            <input name="judul" type="text" required value="${esc(k.judul)}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm" />
          </div>
          <div>
            <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">MEDIA / BAHAN *</label>
            <input name="media_bahan" type="text" required value="${esc(k.media_bahan)}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm" />
          </div>
          <div>
            <label class="block label-caps mb-1 text-[#302C25] dark:text-[#F1EBDD]">TAHUN *</label>
            <input name="tahun_pembuatan" type="number" required value="${k.tahun_pembuatan}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2 text-sm tabular-nums" />
          </div>
          <div class="sm:col-span-2 flex justify-end">
            <button type="submit" class="px-5 py-2 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
              Simpan Perubahan (Simulasi)
            </button>
          </div>
        </form>
      </article>`;
    })
    .join('\n');

  const daftarPameranHtml = seniman.pameran
    .map(
      (p) => `
      <article class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-5">
        <div class="flex flex-wrap items-start justify-between gap-3">
          <div>
            <span class="px-2 py-0.5 bg-[#D4A943] text-[#302C25] text-xs font-bold tabular-nums rounded-[0.125rem]">${p.tahun}</span>
            <h3 class="mt-2 font-display text-xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">${esc(p.nama_pameran)}</h3>
            <p class="text-xs text-[#68705C] dark:text-[#B8BDAA]">${esc(p.lokasi)}</p>
            <p class="mt-2 text-sm text-[#302C25] dark:text-[#F1EBDD]/90">${esc(p.deskripsi)}</p>
          </div>
          <form data-demo-aksi="Mode Pratinjau Statis: Penghapusan riwayat pameran memerlukan backend Laravel 13 & PostgreSQL.">
            <button type="submit" class="px-3 py-1.5 border border-[#BA1A1A] text-[#BA1A1A] dark:text-[#FFDAD6] text-xs font-semibold rounded-[0.25rem] hover:bg-[#BA1A1A] hover:text-[#FBF9F2]">
              Hapus
            </button>
          </form>
        </div>
      </article>`
    )
    .join('\n');

  return `
  <section class="bg-[#354638] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10">
      <div class="mb-6 bg-[#29382D] dark:bg-[#171D18] border border-[#D4A943]/50 rounded-[0.25rem] px-4 py-2.5 text-xs text-[#EAE5D5] dark:text-[#B8BDAA]">
        <strong class="text-[#D4A943]">PRATINJAU DEMONSTRASI STATIS:</strong> Menampilkan antarmuka Dasbor Seniman dengan data contoh Baskoro Wijaya. Operasi CRUD & penyimpanan berkas aktif pada backend Laravel 13 & PostgreSQL.
      </div>

      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex items-center gap-5">
          ${renderFotoSeniman(seniman, 'avatar-lg')}
          <div>
            <p class="label-caps text-[#D4A943]">DASBOR SENIMAN</p>
            <h1 class="mt-1 font-display text-3xl sm:text-4xl font-semibold">${esc(seniman.nama_lengkap)}</h1>
            <p class="mt-1 text-xs text-[#EAE5D5] dark:text-[#B8BDAA]">${esc(seniman.kota)} · ${esc(seniman.disiplin)}</p>
          </div>
        </div>

        <a href="/seniman/${esc(seniman.slug)}/" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#D4A943] text-[#302C25] hover:bg-[#FBF9F2] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem] transition-colors whitespace-nowrap self-start md:self-end">
          Lihat Profil Publik Saya →
        </a>
      </div>

      <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-[#29382D] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">KARYA TERBIT</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">${karyaSaya.length}</p>
          <p class="mt-1 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">Karya langsung terbit di katalog publik</p>
        </div>
        <div class="bg-[#29382D] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">RIWAYAT PAMERAN</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">${seniman.pameran.length}</p>
          <p class="mt-1 text-xs text-[#D6D1C2] dark:text-[#B8BDAA]">Tampil terpadu di halaman profil Anda</p>
        </div>
        <div class="bg-[#29382D] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">KELENGKAPAN PROFIL</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">100%</p>
          <div class="mt-2 h-1.5 w-full bg-[#171D18] overflow-hidden">
            <div class="h-full bg-[#D4A943]" style="width: 100%"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
    <section data-panel-dasbor="karya" class="space-y-10">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-5 bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6 lg:p-8">
          <p class="label-caps text-[#354638] dark:text-[#D4A943]">TERBITKAN KARYA BARU</p>
          <h2 class="mt-2 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Tambah Karya Seni</h2>
          <p class="mt-1 text-xs text-[#68705C] dark:text-[#B8BDAA]">Karya yang ditambahkan akan langsung berstatus <strong>TERBIT</strong> pada katalog publik.</p>

          <form data-demo-aksi="Mode Pratinjau Statis: Formulir tambah karya siap dipakai, namun penyimpanan nyata memerlukan backend Laravel 13 & PostgreSQL." class="mt-6 space-y-4">
            <div>
              <label for="judul" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">JUDUL KARYA *</label>
              <input id="judul" name="judul" type="text" required placeholder="Contoh: Monolog Tanah Basah II" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label for="kategori_id" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">KATEGORI</label>
                <select id="kategori_id" name="kategori_id" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3 py-2.5 text-sm">${opsiKat}</select>
              </div>
              <div>
                <label for="tahun_pembuatan" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">TAHUN *</label>
                <input id="tahun_pembuatan" name="tahun_pembuatan" type="number" required value="2026" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm tabular-nums" />
              </div>
            </div>
            <div>
              <label for="media_bahan" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">MEDIA / BAHAN *</label>
              <input id="media_bahan" name="media_bahan" type="text" required placeholder="Cat minyak & pigmen tanah di atas linen" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label for="dimensi" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">DIMENSI</label>
                <input id="dimensi" name="dimensi" type="text" placeholder="120 × 90 cm" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
              </div>
              <div>
                <label for="harga_opsional" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">HARGA OPSIONAL (RP)</label>
                <input id="harga_opsional" name="harga_opsional" type="number" min="0" placeholder="Opsional" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm tabular-nums" />
              </div>
            </div>
            <div>
              <label for="deskripsi" class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">DESKRIPSI KARYA *</label>
              <textarea id="deskripsi" name="deskripsi" rows="3" required placeholder="Ceritakan gagasan, proses, dan konteks karya..." class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm"></textarea>
            </div>
            <button type="submit" class="w-full py-3 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
              Terbitkan Karya (Simulasi)
            </button>
          </form>
        </div>

        <div class="lg:col-span-7 space-y-5">
          <div class="flex items-center justify-between gap-4 pb-3 border-b border-[#D6D1C2] dark:border-[#3A4637]">
            <h2 class="font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Daftar Karya Saya</h2>
            <span class="text-xs font-semibold text-[#68705C] dark:text-[#B8BDAA] tabular-nums">${karyaSaya.length} Karya</span>
          </div>
          ${daftarKaryaHtml}
        </div>
      </div>
    </section>

    <section data-panel-dasbor="profil" class="hidden">
      <div class="max-w-4xl bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6 lg:p-10">
        <p class="label-caps text-[#354638] dark:text-[#D4A943]">IDENTITAS PORTOFOLIO</p>
        <h2 class="mt-2 font-display text-2xl sm:text-3xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Kelola Profil Seniman</h2>
        <form data-demo-aksi="Mode Pratinjau Statis: Pembaruan profil seniman memerlukan backend Laravel 13 & PostgreSQL." class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">NAMA LENGKAP *</label>
            <input name="nama_lengkap" type="text" required value="${esc(seniman.nama_lengkap)}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
          </div>
          <div>
            <label class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">KOTA *</label>
            <input name="kota" type="text" required value="${esc(seniman.kota)}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
          </div>
          <div class="md:col-span-2">
            <label class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">DISIPLIN BERKESENIAN *</label>
            <input name="disiplin" type="text" required value="${esc(seniman.disiplin)}" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
          </div>
          <div class="md:col-span-2">
            <label class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">BIOGRAFI LENGKAP *</label>
            <textarea name="biografi" rows="3" required class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm">${esc(seniman.biografi)}</textarea>
          </div>
          <div class="md:col-span-2 flex justify-end pt-3">
            <button type="submit" class="px-7 py-3 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
              Simpan Perubahan Profil (Simulasi)
            </button>
          </div>
        </form>
      </div>
    </section>

    <section data-panel-dasbor="pameran" class="hidden">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-5 bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6 lg:p-8">
          <p class="label-caps text-[#354638] dark:text-[#D4A943]">ARSIP PROFIL SENIMAN</p>
          <h2 class="mt-2 font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Tambah Riwayat Pameran</h2>
          <form data-demo-aksi="Mode Pratinjau Statis: Penambahan riwayat pameran memerlukan backend Laravel 13 & PostgreSQL." class="mt-6 space-y-4">
            <div>
              <label class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">NAMA PAMERAN *</label>
              <input name="nama_pameran" type="text" required placeholder="Contoh: Biennale Seni Rupa Nusantara" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
            </div>
            <div class="grid grid-cols-3 gap-3">
              <div class="col-span-2">
                <label class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">LOKASI *</label>
                <input name="lokasi" type="text" required placeholder="Museum / Galeri, Kota" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm" />
              </div>
              <div>
                <label class="block label-caps text-[#302C25] dark:text-[#F1EBDD] mb-1.5">TAHUN *</label>
                <input name="tahun" type="number" required value="2026" class="w-full bg-[#F4F1E6] dark:bg-[#171D18] text-[#302C25] dark:text-[#F1EBDD] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] px-3.5 py-2.5 text-sm tabular-nums" />
              </div>
            </div>
            <button type="submit" class="w-full py-3 bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2] font-bold text-xs uppercase tracking-[0.12em] rounded-[0.25rem] transition-colors">
              Tambahkan ke Profil (Simulasi)
            </button>
          </form>
        </div>

        <div class="lg:col-span-7 space-y-4">
          <h2 class="font-display text-2xl font-semibold text-[#302C25] dark:text-[#F1EBDD] pb-3 border-b border-[#D6D1C2] dark:border-[#3A4637]">
            Riwayat Pameran Tercatat
          </h2>
          ${daftarPameranHtml}
        </div>
      </div>
    </section>
  </div>`;
}

function halamanDasborAdmin() {
  const barisKarya = KARYA.map((k) => {
    const s = cariSeniman(k.seniman_slug);
    const kat = cariKategori(k.kategori_slug);
    return `
    <tr class="hover:bg-[#F4F1E6] dark:hover:bg-[#20291F]/60">
      <td class="py-3.5 px-4">
        <div class="flex items-center gap-3">
          ${
            k.foto_karya
              ? `<img src="${esc(k.foto_karya)}" alt="${esc(k.judul)}" class="h-11 w-11 object-cover bg-[#EAE5D5] shrink-0" />`
              : `<div class="h-11 w-11 flex items-center justify-center bg-[#EAE5D5] dark:bg-[#20291F] text-[10px] font-display text-[#302C25] dark:text-[#F1EBDD] shrink-0">AS</div>`
          }
          <a href="/karya/${esc(k.slug)}/" class="font-display font-semibold text-[#302C25] dark:text-[#F1EBDD] hover:underline">${esc(k.judul)}</a>
        </div>
      </td>
      <td class="py-3.5 px-4 text-[#302C25] dark:text-[#F1EBDD]"><a href="/seniman/${esc(s.slug)}/" class="hover:underline">${esc(s.nama_lengkap)}</a></td>
      <td class="py-3.5 px-4 text-[#68705C] dark:text-[#B8BDAA]">${esc(kat.nama)}</td>
      <td class="py-3.5 px-4 tabular-nums text-[#68705C] dark:text-[#B8BDAA]">${k.tahun_pembuatan}</td>
      <td class="py-3.5 px-4">
        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.12em] rounded-[0.125rem] bg-[#354638] text-[#FBF9F2] dark:bg-[#A5B18A] dark:text-[#171D18]">${k.status}</span>
      </td>
      <td class="py-3.5 px-4 text-right whitespace-nowrap">
        <div class="inline-flex items-center gap-2">
          <form data-demo-aksi="Mode Pratinjau Statis: Moderasi status karya aktif pada backend Laravel 13 & PostgreSQL.">
            <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-[0.25rem] border border-[#D4A943] bg-[#D4A943] text-[#302C25] hover:bg-[#354638] hover:text-[#FBF9F2]">Tangguhkan</button>
          </form>
          <form data-demo-aksi="Mode Pratinjau Statis: Penghapusan karya pelanggaran aktif pada backend Laravel 13 & PostgreSQL.">
            <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-[0.25rem] border border-[#BA1A1A] text-[#BA1A1A] dark:text-[#FFDAD6] hover:bg-[#BA1A1A] hover:text-[#FBF9F2]">Hapus</button>
          </form>
        </div>
      </td>
    </tr>`;
  }).join('\n');

  const barisPengguna = AKUN_PENGGUNA.map(
    (u) => `
    <tr>
      <td class="py-3 px-4 font-medium text-[#302C25] dark:text-[#F1EBDD]">${esc(u.nama)}</td>
      <td class="py-3 px-4 text-xs text-[#68705C] dark:text-[#B8BDAA]">${esc(u.surel)}</td>
      <td class="py-3 px-4 uppercase text-xs font-semibold text-[#354638] dark:text-[#D4A943]">${esc(u.peran)}</td>
      <td class="py-3 px-4 text-xs font-semibold text-[#354638] dark:text-[#A5B18A]">Aktif</td>
      <td class="py-3 px-4 text-right">
        ${
          u.peran === 'admin'
            ? `<span class="text-xs text-[#68705C] dark:text-[#B8BDAA]">Terlindungi</span>`
            : `<form data-demo-aksi="Mode Pratinjau Statis: Perubahan status akun pengguna aktif pada backend Laravel 13 & PostgreSQL."><button type="submit" class="px-3 py-1 text-xs font-semibold border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] rounded-[0.25rem] hover:bg-[#354638] hover:text-[#FBF9F2]">Nonaktifkan</button></form>`
        }
      </td>
    </tr>`
  ).join('\n');

  const laporanKat = KATEGORI.map((kat) => {
    const jumlah = KARYA.filter((k) => k.kategori_slug === kat.slug).length;
    const persen = Math.round((jumlah / KARYA.length) * 100);
    return `
    <div>
      <div class="flex justify-between text-xs font-medium text-[#302C25] dark:text-[#F1EBDD] mb-1">
        <span>${esc(kat.nama)}</span>
        <span class="tabular-nums font-semibold">${jumlah} Karya</span>
      </div>
      <div class="h-2 w-full bg-[#EAE5D5] dark:bg-[#171D18] overflow-hidden">
        <div class="h-full bg-[#354638] dark:bg-[#D4A943]" style="width: ${persen}%"></div>
      </div>
    </div>`;
  }).join('\n');

  const ringkasanSeniman = SENIMAN.map((s) => {
    const jmlKarya = KARYA.filter((k) => k.seniman_slug === s.slug).length;
    return `
    <li class="py-2.5 flex items-center justify-between gap-3">
      <a href="/seniman/${esc(s.slug)}/" class="font-medium text-[#302C25] dark:text-[#F1EBDD] hover:underline truncate">${esc(s.nama_lengkap)}</a>
      <span class="text-xs text-[#68705C] dark:text-[#B8BDAA] tabular-nums shrink-0">${jmlKarya} karya · ${s.pameran.length} pameran</span>
    </li>`;
  }).join('\n');

  return `
  <section class="bg-[#29382D] dark:bg-[#20291F] text-[#FBF9F2] dark:text-[#F1EBDD] border-b-2 border-[#D4A943]">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10">
      <div class="mb-6 bg-[#354638] dark:bg-[#171D18] border border-[#D4A943]/50 rounded-[0.25rem] px-4 py-2.5 text-xs text-[#EAE5D5] dark:text-[#B8BDAA]">
        <strong class="text-[#D4A943]">PRATINJAU DEMONSTRASI STATIS:</strong> Menampilkan antarmuka Dasbor Admin dengan data contoh. Moderasi & pengelolaan akun nyata aktif pada backend Laravel 13 & PostgreSQL.
      </div>

      <p class="label-caps text-[#D4A943]">ADMINISTRASI & PEMANTAUAN SISTEM</p>
      <h1 class="mt-2 font-display text-3xl sm:text-4xl font-semibold">Dasbor Admin ARTSPACE</h1>
      <p class="mt-2 text-sm text-[#EAE5D5] dark:text-[#B8BDAA] max-w-2xl">
        Pantau akun pengguna, direktori seniman, seluruh karya seni yang terbit, tangani konten yang melanggar ketentuan, serta tinjau laporan data sistem.
      </p>

      <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-[#354638] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">TOTAL PENGGUNA</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">${AKUN_PENGGUNA.length}</p>
        </div>
        <div class="bg-[#354638] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">SENIMAN TERDAFTAR</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">${SENIMAN.length}</p>
        </div>
        <div class="bg-[#354638] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">KARYA TERBIT</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">${KARYA.length}</p>
        </div>
        <div class="bg-[#354638] dark:bg-[#293326] border border-[#77805B]/40 dark:border-[#3A4637] rounded-[0.25rem] p-5">
          <p class="label-caps text-[#D4A943]">KONTEN DITANGGUHKAN</p>
          <p class="mt-2 font-display text-3xl font-semibold tabular-nums">0</p>
        </div>
      </div>
    </div>
  </section>

  <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 py-10 space-y-12">
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
            ${barisKarya}
          </tbody>
        </table>
      </div>
    </section>

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
              ${barisPengguna}
            </tbody>
          </table>
        </div>
      </section>

      <section class="lg:col-span-4 space-y-6">
        <div class="bg-[#FBF9F2] dark:bg-[#293326] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6">
          <p class="label-caps text-[#354638] dark:text-[#D4A943]">LAPORAN DATA SISTEM</p>
          <h2 class="mt-1 font-display text-xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Distribusi Kategori Karya</h2>
          <div class="mt-5 space-y-3.5">${laporanKat}</div>
        </div>

        <div class="bg-[#EAE5D5] dark:bg-[#20291F] border border-[#D6D1C2] dark:border-[#3A4637] rounded-[0.25rem] p-6">
          <p class="label-caps text-[#354638] dark:text-[#D4A943]">RINGKASAN SENIMAN</p>
          <ul class="mt-4 divide-y divide-[#D6D1C2] dark:divide-[#3A4637] text-sm">${ringkasanSeniman}</ul>
        </div>
      </section>
    </div>
  </div>`;
}

function halaman404() {
  return `
  <section class="max-w-2xl mx-auto px-4 py-24 text-center">
    <p class="label-caps text-[#354638] dark:text-[#D4A943]">HALAMAN TIDAK DITEMUKAN · 404</p>
    <h1 class="mt-3 font-display text-4xl font-semibold text-[#302C25] dark:text-[#F1EBDD]">Konten Tidak Tersedia</h1>
    <p class="mt-4 text-sm sm:text-base text-[#68705C] dark:text-[#B8BDAA] leading-relaxed">
      Karya seni, profil seniman, atau alamat halaman yang Anda tuju tidak ditemukan pada arsip ARTSPACE.
    </p>
    <div class="mt-8 flex flex-wrap justify-center gap-3">
      <a href="/" class="px-6 py-3 bg-[#D4A943] text-[#302C25] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
        Kembali ke Beranda
      </a>
      <a href="/seniman/" class="px-6 py-3 border border-[#354638] dark:border-[#A5B18A] text-[#354638] dark:text-[#A5B18A] font-semibold text-xs uppercase tracking-[0.1em] rounded-[0.25rem]">
        Temukan Seniman
      </a>
    </div>
  </section>`;
}

export function buildPrototypeDist(rootDir = process.cwd()) {
  const buildDir = path.resolve(rootDir, 'public/build');
  const imagesDir = path.resolve(rootDir, 'public/images');
  const distDir = path.resolve(rootDir, 'dist');
  const manifestPath = path.join(buildDir, 'manifest.json');

  if (!fs.existsSync(manifestPath)) {
    throw new Error('public/build/manifest.json tidak ditemukan. Jalankan Vite build Laravel terlebih dahulu.');
  }

  fs.rmSync(distDir, { recursive: true, force: true });
  fs.mkdirSync(distDir, { recursive: true });
  fs.cpSync(buildDir, distDir, { recursive: true });

  if (fs.existsSync(imagesDir)) {
    fs.cpSync(imagesDir, path.join(distDir, 'images'), { recursive: true });
  }

  const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf-8'));
  const cssFile = manifest['resources/css/app.css']?.file;
  const jsFile = manifest['resources/js/app.js']?.file;

  if (!cssFile || !jsFile) {
    throw new Error('Aset app.css atau app.js tidak ditemukan pada manifest.json.');
  }

  const statusGambar = sinkronkanAsetGambar(imagesDir);
  if (statusGambar.stitchTersedia.length === DAFTAR_GAMBAR_STITCH.length) {
    console.log(`[ARTSPACE] Seluruh 4 gambar asli Stitch terverifikasi di public/images/.`);
  } else if (statusGambar.stitchTersedia.length > 0) {
    console.warn(
      `[ARTSPACE] Sebagian gambar Stitch belum ditemukan (${statusGambar.stitchHilang.join(', ')}); menggunakan gambar Stitch yang tersedia (${statusGambar.stitchTersedia.join(', ')}).`
    );
  } else {
    console.warn(
      `[ARTSPACE] 4 file PNG Stitch (${DAFTAR_GAMBAR_STITCH.join(', ')}) belum ada di public/images/; sementara menyinkronkan ke ${statusGambar.fileTersedia.length} file gambar yang tersedia agar tidak ada gambar rusak.`
    );
  }

  // 1. Halaman Utama & Direktori
  tulisHalaman(distDir, 'index.html', renderLayout({
    judul: 'ARTSPACE — Jelajahi Karya Seni & Profil Seniman',
    aktif: 'beranda',
    konten: halamanBeranda(),
    cssFile,
    jsFile,
  }));

  tulisHalaman(distDir, 'jelajahi/index.html', renderLayout({
    judul: 'Jelajahi Karya Seni — ARTSPACE',
    aktif: 'jelajahi',
    konten: halamanJelajahi(),
    cssFile,
    jsFile,
  }));

  tulisHalaman(distDir, 'seniman/index.html', renderLayout({
    judul: 'Temukan Seniman — ARTSPACE',
    aktif: 'seniman',
    konten: halamanDirektoriSeniman(),
    cssFile,
    jsFile,
  }));

  // 2. Seluruh Halaman Detail Karya (termasuk /karya/strata-zaitun-oker-iv/ dan seluruh karya lainnya)
  for (const k of KARYA) {
    const s = cariSeniman(k.seniman_slug);
    const html = renderLayout({
      judul: `${k.judul} — ${s.nama_lengkap} | ARTSPACE`,
      aktif: 'jelajahi',
      konten: halamanDetailKarya(k),
      cssFile,
      jsFile,
    });
    tulisHalaman(distDir, `karya/${k.slug}/index.html`, html);
    if (k.alias_slug) {
      tulisHalaman(distDir, `karya/${k.alias_slug}/index.html`, html);
    }
  }

  // 3. Seluruh Halaman Profil Seniman (termasuk /seniman/baskoro-wijaya/ dan seluruh seniman lainnya)
  for (const s of SENIMAN) {
    tulisHalaman(distDir, `seniman/${s.slug}/index.html`, renderLayout({
      judul: `${s.nama_lengkap} — Profil Seniman | ARTSPACE`,
      aktif: 'seniman',
      konten: halamanProfilSeniman(s),
      cssFile,
      jsFile,
    }));
  }

  // 4. Autentikasi & Dasbor Demo
  tulisHalaman(distDir, 'masuk/index.html', renderLayout({
    judul: 'Masuk ke ARTSPACE',
    aktif: 'masuk',
    konten: halamanMasuk(),
    cssFile,
    jsFile,
  }));

  tulisHalaman(distDir, 'daftar/index.html', renderLayout({
    judul: 'Daftar Akun Seniman — ARTSPACE',
    aktif: 'daftar',
    konten: halamanDaftar(),
    cssFile,
    jsFile,
  }));

  tulisHalaman(distDir, 'dasbor-seniman/index.html', renderLayout({
    judul: 'Dasbor Seniman — ARTSPACE',
    aktif: 'dasbor-seniman',
    konten: halamanDasborSeniman(),
    cssFile,
    jsFile,
  }));

  tulisHalaman(distDir, 'dasbor-admin/index.html', renderLayout({
    judul: 'Dasbor Admin — ARTSPACE',
    aktif: 'dasbor-admin',
    konten: halamanDasborAdmin(),
    cssFile,
    jsFile,
  }));

  // 5. Halaman 404 Bahasa Indonesia untuk Vercel
  tulisHalaman(distDir, '404.html', renderLayout({
    judul: 'Halaman Tidak Ditemukan — ARTSPACE',
    aktif: '',
    konten: halaman404(),
    cssFile,
    jsFile,
  }));
}
