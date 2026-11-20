<?php

namespace Database\Seeders;

use App\Models\KaryaSeni;
use App\Models\KategoriKarya;
use App\Models\Pengguna;
use App\Models\RiwayatPameran;
use App\Models\Seniman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Administrator Sistem
        Pengguna::updateOrCreate(
            ['surel' => 'admin@artspace.id'],
            [
                'nama' => 'Administrator ARTSPACE',
                'kata_sandi' => Hash::make('admin123'),
                'peran' => 'admin',
                'aktif' => true,
            ]
        );

        // 2. Kategori Karya
        $kategoriData = [
            ['nama' => 'Lukisan', 'slug' => 'lukisan', 'deskripsi' => 'Karya lukis minyak, akrilik, pigmen alam, dan media datar kontemporer.'],
            ['nama' => 'Patung & Keramik', 'slug' => 'patung-keramik', 'deskripsi' => 'Karya tiga dimensi berbahan perunggu, batu vulkanik, dan keramik stoneware.'],
            ['nama' => 'Fotografi', 'slug' => 'fotografi', 'deskripsi' => 'Fotografi arsitektur, analog format besar, dan cetakan arsip.'],
            ['nama' => 'Tekstil & Relief', 'slug' => 'tekstil-relief', 'deskripsi' => 'Tenun arsitektural, serat alam, dan relief dinding mineral.'],
            ['nama' => 'Kertas & Media Campuran', 'slug' => 'kertas-media-campuran', 'deskripsi' => 'Kolase kertas serat murbei, tinta sumi, dan eksplorasi kertas kapas.'],
        ];

        $kategoriMap = [];
        foreach ($kategoriData as $kat) {
            $kategoriMap[$kat['slug']] = KategoriKarya::updateOrCreate(['slug' => $kat['slug']], $kat);
        }

        // 3. Data Seniman Lengkap (Profil + Riwayat Pameran)
        $daftarSeniman = [
            [
                'surel' => 'baskoro@artspace.id',
                'sandi' => 'artspace123',
                'slug' => 'baskoro-wijaya',
                'nama_lengkap' => 'Baskoro Wijaya',
                'kota' => 'Yogyakarta',
                'disiplin' => 'Lukisan Mineral & Media Campuran',
                'foto_profil' => 'images/artist_studio_portrait_1795137301009.jpg',
                'biografi_singkat' => 'Perupa lukis dan media campuran asal Yogyakarta yang meneliti lapisan pigmen tanah vulkanik dan struktur ruang sunyi.',
                'biografi' => 'Baskoro Wijaya bekerja dengan pigmen tanah vulkanik, cat minyak, lilin dingin, dan kertas serat murbei di atas linen mentah. Karyanya membaca ulang bobot material geologis dalam komposisi bidang warna arsitektural.',
                'latar_belakang' => 'Sarjana Seni Lukis Institut Seni Indonesia (ISI) Yogyakarta dan alumnus residensi seni rupa kontemporer di Basel serta Tokyo.',
                'perjalanan_berkesenian' => 'Memulai praktik seni rupa sejak 2006 dengan eksplorasi cat minyak figuratif sebelum beralih pada abstraksi tektonik berbahan mineral alami pada 2015.',
                'pengalaman' => '18 tahun praktik studio penuh waktu, dosen tamu seni lukis kontemporer, dan kolaborator ruang pamer arsitektur Asia Tenggara.',
                'pameran' => [
                    ['nama_pameran' => 'Lapisan Sunyi: Studi Pigmen Tanah', 'lokasi' => 'Galeri Nasional Indonesia, Jakarta', 'tahun' => 2026, 'deskripsi' => 'Pameran tunggal menampilkan dua belas lukisan impasto linen mentah berskala besar.'],
                    ['nama_pameran' => 'Tectonic Fields Asia Tenggara', 'lokasi' => 'Singapore Art Museum, Singapura', 'tahun' => 2025, 'deskripsi' => 'Pameran kelompok lintas negara mengenai materialitas bumi dalam seni rupa modern.'],
                    ['nama_pameran' => 'Ruang & Residu', 'lokasi' => 'Jogja National Museum, Yogyakarta', 'tahun' => 2023, 'deskripsi' => 'Pameran duo mengeksplorasi arsip tanah vulkanik Merapi pada bidang kanvas.'],
                ],
            ],
            [
                'surel' => 'ratna@artspace.id',
                'sandi' => 'artspace123',
                'slug' => 'ratna-kusumawati',
                'nama_lengkap' => 'Ratna Kusumawati',
                'kota' => 'Bandung',
                'disiplin' => 'Keramik Stoneware & Patung Perunggu',
                'foto_profil' => 'images/potret_seniman_perempuan_1795141268117.jpg',
                'biografi_singkat' => 'Pematung dan perupa keramik berbasis di Bandung yang merancang bejana kontemplatif serta bentuk organik berbahan tanah liat dan perunggu.',
                'biografi' => 'Ratna Kusumawati mengolah tanah liat lokal Jawa Barat dengan pembakaran tungku kayu suhu tinggi serta pengecoran perunggu teknik lost-wax untuk menghadirkan keheningan bentuk arsitektural.',
                'latar_belakang' => 'Magister Seni Rupa Fakultas Seni Rupa dan Desain (FSRD) ITB Bandung; pernah menjalani program studi keramik tradisional di Mashiko, Jepang.',
                'perjalanan_berkesenian' => 'Mengembangkan teknik glasir abu sekam dan oksida tembaga sejak 2012 untuk menghasilkan patina zaitun matte khas pada karya tiga dimensi.',
                'pengalaman' => 'Pendiri Studio Tanah & Logam Bandung, kurator tamu Biennale Keramik Indonesia, dan penerima hibah riset kriya kontemporer.',
                'pameran' => [
                    ['nama_pameran' => 'Bejana Keheningan', 'lokasi' => 'Selasar Sunaryo Art Space, Bandung', 'tahun' => 2026, 'deskripsi' => 'Pameran tunggal dua puluh karya bejana stoneware dan patung perunggu.'],
                    ['nama_pameran' => 'Forms of Earth & Fire', 'lokasi' => 'Museum MACAN, Jakarta', 'tahun' => 2024, 'deskripsi' => 'Eksplorasi keramik kontemporer Nusantara dan dialognya dengan ruang arsitektur.'],
                ],
            ],
            [
                'surel' => 'darmawan@artspace.id',
                'sandi' => 'artspace123',
                'slug' => 'darmawan-setiadi',
                'nama_lengkap' => 'Darmawan Setiadi',
                'kota' => 'Jakarta',
                'disiplin' => 'Fotografi Arsitektur & Cetakan Arsip',
                'foto_profil' => 'images/hero_exhibition_pavilion_1795137300545.jpg',
                'biografi_singkat' => 'Fotografer arsitektur format besar yang merekam pertemuan cahaya matahari tropis, bayangan beton, dan ritme ruang publik.',
                'biografi' => 'Darmawan Setiadi bekerja secara eksklusif menggunakan kamera analog format besar 4x5 inci dan cetakan arsip kertas kapas untuk menangkap geometri cahaya alami tanpa manipulasi digital.',
                'latar_belakang' => 'Lulusan Arsitektur Universitas Indonesia yang memperdalam fotografi dokumenter dan pencetakan kamar gelap di Amsterdam.',
                'perjalanan_berkesenian' => 'Sejak 2014 mendokumentasikan arsitektur modernis tropis Indonesia dalam seri monografi fotografi hitam-putih dan nada hangat.',
                'pengalaman' => 'Kontributor monografi arsitektur Nusantara dan pengajar lokakarya fotografi analog format besar.',
                'pameran' => [
                    ['nama_pameran' => 'Bayangan Kolonade', 'lokasi' => 'Erasmus Huis, Jakarta', 'tahun' => 2025, 'deskripsi' => 'Seri cetak arsip format besar mengenai cahaya sore pada bangunan publik bersejarah.'],
                    ['nama_pameran' => 'Monolith Tropis', 'lokasi' => 'Biennale Arsitektur Indonesia, Semarang', 'tahun' => 2024, 'deskripsi' => 'Instalasi fotografi berskala dinding menampilkan ritme struktur beton modernis.'],
                ],
            ],
            [
                'surel' => 'sekarsari@artspace.id',
                'sandi' => 'artspace123',
                'slug' => 'sekar-ayu-prameswari',
                'nama_lengkap' => 'Sekar Ayu Prameswari',
                'kota' => 'Denpasar',
                'disiplin' => 'Tekstil Serat Alam & Relief Dinding',
                'foto_profil' => 'images/exhibition_pavilion_hall_1795137300627.jpg',
                'biografi_singkat' => 'Perupa tekstil dan relief kontemporer asal Bali yang memadukan pewarna alam kunyit, daun ketapang, dan batu kapur ukir.',
                'biografi' => 'Sekar Ayu Prameswari menjembatani tradisi tenun tangan dan relief mineral kontemporer melalui komposisi tekstil berskala arsitektural dengan palet oker, zaitun, dan krem alami.',
                'latar_belakang' => 'Sarjana Desain Tekstil Institut Seni Indonesia (ISI) Denpasar dan peneliti pewarna alami botani Nusantara.',
                'perjalanan_berkesenian' => 'Berkolaborasi bersama penenun desa di Bali Timur dan Nusa Tenggara untuk menciptakan tekstil pamer non-komersial berbasis arsip botani.',
                'pengalaman' => 'Perupa residensi Textile Art Kyoto 2024 dan narasumber pelestarian serat alami kontemporer.',
                'pameran' => [
                    ['nama_pameran' => 'Tenun Tanah & Oker', 'lokasi' => 'Museum Puri Lukisan, Ubud', 'tahun' => 2026, 'deskripsi' => 'Instalasi tekstil tenun serat rami dengan pewarnaan kulit kayu dan kunyit.'],
                    ['nama_pameran' => 'Serat Ingatan Nusantara', 'lokasi' => 'Bentara Budaya, Bali', 'tahun' => 2023, 'deskripsi' => 'Pameran kolaboratif tekstil arsitektural dan relief batu kapur.'],
                ],
            ],
        ];

        $senimanMap = [];
        foreach ($daftarSeniman as $item) {
            $pengguna = Pengguna::updateOrCreate(
                ['surel' => $item['surel']],
                [
                    'nama' => $item['nama_lengkap'],
                    'kata_sandi' => Hash::make($item['sandi']),
                    'peran' => 'seniman',
                    'aktif' => true,
                ]
            );

            $seniman = Seniman::updateOrCreate(
                ['pengguna_id' => $pengguna->id],
                [
                    'slug' => $item['slug'],
                    'nama_lengkap' => $item['nama_lengkap'],
                    'kota' => $item['kota'],
                    'disiplin' => $item['disiplin'],
                    'foto_profil' => $item['foto_profil'],
                    'biografi_singkat' => $item['biografi_singkat'],
                    'biografi' => $item['biografi'],
                    'latar_belakang' => $item['latar_belakang'],
                    'perjalanan_berkesenian' => $item['perjalanan_berkesenian'],
                    'pengalaman' => $item['pengalaman'],
                ]
            );

            $senimanMap[$item['slug']] = $seniman;

            foreach ($item['pameran'] as $pameran) {
                RiwayatPameran::updateOrCreate(
                    [
                        'seniman_id' => $seniman->id,
                        'nama_pameran' => $pameran['nama_pameran'],
                        'tahun' => $pameran['tahun'],
                    ],
                    [
                        'lokasi' => $pameran['lokasi'],
                        'deskripsi' => $pameran['deskripsi'],
                    ]
                );
            }
        }

        // 4. Data Karya Seni (Langsung TERBIT, proporsi gambar beragam untuk Masonry Pinterest)
        $daftarKarya = [
            [
                'slug' => 'strata-zaitun-dan-oker-iv',
                'seniman' => 'baskoro-wijaya',
                'kategori' => 'lukisan',
                'judul' => 'Strata Zaitun & Oker IV',
                'deskripsi' => 'Komposisi impasto tebal berbahan pigmen tanah vulkanik, cat minyak, dan lilin dingin di atas linen Belgia mentah tanpa bingkai luar.',
                'tahun_pembuatan' => 2026,
                'media_bahan' => 'Cat minyak, pigmen tanah vulkanik, dan lilin dingin di atas linen mentah',
                'dimensi' => '195 × 145 cm',
                'informasi_tambahan' => 'Karya unik seri Strata Geologis; dikerjakan selama empat bulan dengan teknik pisau palet berlapis.',
                'harga_opsional' => 285000000,
                'foto_karya' => 'images/artwork_terracotta_monolith_1795137300116.jpg',
            ],
            [
                'slug' => 'bejana-stoneware-lumut-tinggi',
                'seniman' => 'ratna-kusumawati',
                'kategori' => 'patung-keramik',
                'judul' => 'Bejana Stoneware Lumut Tinggi',
                'deskripsi' => 'Eksplorasi vertikalitas bejana tanah liat bakar suhu 1.280°C dengan glasir abu sekam dan aksen mineral kuning mustard alami.',
                'tahun_pembuatan' => 2026,
                'media_bahan' => 'Keramik stoneware bakar tungku kayu, glasir abu sekam',
                'dimensi' => '82 × 28 × 28 cm',
                'informasi_tambahan' => 'Dibentuk secara manual dengan teknik pilin (coiling) tanpa cetakan pabrik.',
                'harga_opsional' => 64000000,
                'foto_karya' => 'images/karya_keramik_tanah_liat_1795141267838.jpg',
            ],
            [
                'slug' => 'kolonade-pukul-empat',
                'seniman' => 'darmawan-setiadi',
                'kategori' => 'fotografi',
                'judul' => 'Kolonade Pukul Empat',
                'deskripsi' => 'Rekaman analog format besar 4×5 inci mengenai garis cahaya sore yang membelah selasar beton modernis dalam keheningan.',
                'tahun_pembuatan' => 2025,
                'media_bahan' => 'Cetakan arsip kertas kapas 310 gsm dari negatif film 4×5 inci',
                'dimensi' => '110 × 145 cm',
                'informasi_tambahan' => 'Edisi terbatas 1 dari 5; dilengkapi sertifikat arsip studio fotografer.',
                'harga_opsional' => null,
                'foto_karya' => 'images/artwork_architectural_shadow_1795137301125.jpg',
            ],
            [
                'slug' => 'arsip-kertas-murbei-07',
                'seniman' => 'baskoro-wijaya',
                'kategori' => 'kertas-media-campuran',
                'judul' => 'Arsip Kertas Murbei No. 07',
                'deskripsi' => 'Kolase kertas buatan tangan berbahan kulit pohon murbei, sapuan pigmen oker, dan bidang zaitun tua yang disusun dengan keseimbangan geometris.',
                'tahun_pembuatan' => 2026,
                'media_bahan' => 'Kolase kertas murbei, pigmen mineral oker, dan tinta karbon di atas papan arsip',
                'dimensi' => '90 × 90 cm',
                'informasi_tambahan' => 'Bagian dari seri riset kertas arsip Nusantara.',
                'harga_opsional' => 42000000,
                'foto_karya' => 'images/karya_kolase_kertas_arsip_1795141267716.jpg',
            ],
            [
                'slug' => 'tenun-dinding-oker-senja',
                'seniman' => 'sekar-ayu-prameswari',
                'kategori' => 'tekstil-relief',
                'judul' => 'Tenun Dinding Oker Senja',
                'deskripsi' => 'Permadani dinding tenun tangan dari serat rami dan wol mentah yang dicelup menggunakan ekstrak kunyit tua, daun ketapang, dan lumpur sawah.',
                'tahun_pembuatan' => 2025,
                'media_bahan' => 'Serat rami, kapas tenun tangan, pewarna alami botani',
                'dimensi' => '180 × 125 cm',
                'informasi_tambahan' => 'Ditenun menggunakan alat tenun bukan mesin (ATBM) selama sembilan minggu.',
                'harga_opsional' => 115000000,
                'foto_karya' => 'images/artwork_ochre_tapestry_1795137301114.jpg',
            ],
            [
                'slug' => 'studi-botani-tinta-sumi-ii',
                'seniman' => 'baskoro-wijaya',
                'kategori' => 'kertas-media-campuran',
                'judul' => 'Studi Botani Tinta Sumi II',
                'deskripsi' => 'Sketsa meditasi garis tunggal menggunakan kuas bambu, tinta sumi Jepang, dan sapuan tipis pigmen zaitun pada kertas kapas buatan tangan.',
                'tahun_pembuatan' => 2026,
                'media_bahan' => 'Tinta sumi dan cat air mineral di atas kertas kapas dekled 350 gsm',
                'dimensi' => '76 × 52 cm',
                'informasi_tambahan' => 'Dikerjakan langsung dari observasi kebun studio pada pagi hari.',
                'harga_opsional' => null,
                'foto_karya' => 'images/karya_sketsa_tinta_botani_1795141266938.jpg',
            ],
            [
                'slug' => 'patung-bejana-perunggu-senyap',
                'seniman' => 'ratna-kusumawati',
                'kategori' => 'patung-keramik',
                'judul' => 'Bejana Perunggu Senyap',
                'deskripsi' => 'Karya patung cor perunggu padat dengan permukaan berpatina cokelat-zaitun hangat yang menangkap perubahan cahaya sepanjang hari.',
                'tahun_pembuatan' => 2025,
                'media_bahan' => 'Perunggu cor teknik lost-wax, patina oksida alami',
                'dimensi' => '48 × 36 × 34 cm',
                'informasi_tambahan' => 'Dicor di pengecoran logam tradisional Yogyakarta.',
                'harga_opsional' => 135000000,
                'foto_karya' => 'images/artwork_bronze_vessel_1795137300508.jpg',
            ],
            [
                'slug' => 'relief-kapur-geometri-iii',
                'seniman' => 'sekar-ayu-prameswari',
                'kategori' => 'tekstil-relief',
                'judul' => 'Relief Batu Kapur Geometri III',
                'deskripsi' => 'Ukiran dangkal pada panel batu kapur palimanan yang menonjolkan permainan bidang cekung, garis sejajar, dan bayangan alami.',
                'tahun_pembuatan' => 2024,
                'media_bahan' => 'Batu kapur alam pahat tangan dengan lapisan pelindung matte',
                'dimensi' => '120 × 100 × 7 cm',
                'informasi_tambahan' => 'Dirancang untuk ditempatkan pada dinding dengan pencahayaan menyamping.',
                'harga_opsional' => 98000000,
                'foto_karya' => 'images/artwork_limestone_relief_1795137300409.jpg',
            ],
            [
                'slug' => 'paviliun-cahaya-utara',
                'seniman' => 'darmawan-setiadi',
                'kategori' => 'fotografi',
                'judul' => 'Paviliun Cahaya Utara',
                'deskripsi' => 'Dokumentasi ruang pamer minimalis saat sinar matahari pagi menyentuh permukaan lantai batu dan dinding plester kapur.',
                'tahun_pembuatan' => 2026,
                'media_bahan' => 'Cetakan pigmen arsip pada kertas Hahnemühle Photo Rag',
                'dimensi' => '100 × 150 cm',
                'informasi_tambahan' => 'Bagian dari seri Arsitektur Ruang Sunyi 2026.',
                'harga_opsional' => null,
                'foto_karya' => 'images/hero_exhibition_pavilion_1795137300545.jpg',
            ],
            [
                'slug' => 'selasar-batu-dan-hening',
                'seniman' => 'darmawan-setiadi',
                'kategori' => 'fotografi',
                'judul' => 'Selasar Batu & Hening',
                'deskripsi' => 'Komposisi perspektif simetris yang menyoroti tekstur dinding travertine dan proporsi ruang galeri kontemporer.',
                'tahun_pembuatan' => 2024,
                'media_bahan' => 'Cetakan pigmen arsip pada kertas kapas matte',
                'dimensi' => '85 × 125 cm',
                'informasi_tambahan' => 'Pernah dipamerkan pada Biennale Arsitektur Indonesia 2024.',
                'harga_opsional' => 38000000,
                'foto_karya' => 'images/exhibition_pavilion_hall_1795137300627.jpg',
            ],
        ];

        foreach ($daftarKarya as $karya) {
            KaryaSeni::updateOrCreate(
                ['slug' => $karya['slug']],
                [
                    'seniman_id' => $senimanMap[$karya['seniman']]->id,
                    'kategori_id' => $kategoriMap[$karya['kategori']]->id,
                    'judul' => $karya['judul'],
                    'deskripsi' => $karya['deskripsi'],
                    'tahun_pembuatan' => $karya['tahun_pembuatan'],
                    'media_bahan' => $karya['media_bahan'],
                    'dimensi' => $karya['dimensi'],
                    'informasi_tambahan' => $karya['informasi_tambahan'],
                    'harga_opsional' => $karya['harga_opsional'],
                    'foto_karya' => $karya['foto_karya'],
                    'status' => KaryaSeni::STATUS_TERBIT,
                ]
            );
        }
    }
}
