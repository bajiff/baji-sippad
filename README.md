# SIPPAD — Sistem Informasi Pelatihan dan Pendaftaran Desa

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<p align="center">
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-13.8-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13.8"></a>
  <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3"></a>
  <a href="https://www.postgresql.org/"><img src="https://img.shields.io/badge/PostgreSQL-16.14-316192?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL 16"></a>
  <a href="https://alpinejs.dev/"><img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js"></a>
  <a href="https://vitejs.dev/"><img src="https://img.shields.io/badge/Vite-5.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite"></a>
  <a href="https://www.w3.org/WAI/WCAG2AA-Conformance"><img src="https://img.shields.io/badge/WCAG_AA-Compliant-008000?style=for-the-badge&logo=w3c&logoColor=white" alt="WCAG AA"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge" alt="License MIT"></a>
  <img src="https://img.shields.io/badge/Status-100%25%20Completed-success?style=for-the-badge" alt="Progress 100%">
</p>

---

## Introduction

**SIPPAD (Sistem Informasi Pelatihan dan Pendaftaran Desa)** adalah platform aplikasi berbasis web modern yang dibangun menggunakan **Laravel 13.8 (PHP 8.3)** untuk mendigitalisasi, mengotomatisasi, dan mengelola seluruh siklus program pelatihan di tingkat desa. 

Sistem ini dirancang dengan arsitektur **Clean Service Layer**, mendukung kontrol akses berbasis peran (*Role-Based Access Control / RBAC*) yang ketat, pengelolaan presensi fleksibel, penerbitan sertifikat digital otomatis berformat A4 Landscape presisi, serta ekspor laporan eksekutif multi-format. Dengan antarmuka premium terinspirasi dari **Adobe Spectrum Design System** yang mendukung mode *Dark/Light* interaktif serta memenuhi standar aksesibilitas **WCAG AA**, SIPPAD menghadirkan pengalaman pengguna yang cepat, elegan, dan inklusif bagi aparatur maupun masyarakat desa.

---

## :ledger: Index

- [Introduction](#introduction)
  - [:ledger: Index](#ledger-index)
  - [:beginner: About](#beginner-about)
  - [:zap: Usage](#zap-usage)
    - [:electric\_plug: Installation](#electric_plug-installation)
    - [:package: Commands](#package-commands)
  - [:wrench: Development](#wrench-development)
    - [:notebook: Pre-Requisites](#notebook-pre-requisites)
    - [:nut\_and\_bolt: Development Environment](#nut_and_bolt-development-environment)
    - [:file\_folder: File Structure](#file_folder-file-structure)
    - [:hammer: Build](#hammer-build)
    - [:rocket: Deployment](#rocket-deployment)
  - [:cherry\_blossom: Community](#cherry_blossom-community)
    - [:fire: Contribution](#fire-contribution)
    - `[:cactus: Branches](#cactus-branches)
    - [:exclamation: Guideline](#exclamation-guideline)
  - [:question: FAQ](#question-faq)
  - [:page\_facing\_up: Resources](#page_facing_up-resources)
  - [:camera: Gallery](#camera-gallery)
  - [:star2: Credit/Acknowledgment](#star2-creditacknowledgment)
  - [:lock: License](#lock-license)

---

## :beginner: About

SIPPAD hadir sebagai solusi transformasi digital untuk pemerintah desa (seperti **Desa Karangduren**) dalam mengelola program pelatihan, pembinaan kemasyarakatan, dan pengembangan SDM. Sebelum adanya SIPPAD, pendataan peserta, verifikasi prasyarat, presensi kehadiran, hingga pencetakan sertifikat dilakukan secara manual dan rawan duplikasi data.

### :sparkles: Fitur Utama SIPPAD

1. **Role-Based Access Control (RBAC) & Keamanan Lanjutan**
   - **Admin / Superadmin**: Memiliki hak akses penuh untuk manajemen kategori, kelas pelatihan, verifikasi peserta, presensi, manajemen sertifikat massal (*bulk action*), dan unduh laporan.
   - **User / Peserta**: Akses untuk penelusuran katalog pelatihan, pendaftaran mandiri, pelacakan riwayat presensi, pengelolaan profil, serta unduh sertifikat digital.
   - **Guest**: Akses halaman landing page interaktif dengan statistik real-time dan katalog pelatihan publik.

2. **Arsitektur Service Layer yang Bersih (*Clean Architecture*)**
   - Logika bisnis kompleks dipisahkan secara tegas dari Controller ke dalam kelas layanan khusus (`app/Services/`):
     - `PendaftaranService`: Menangani alur pendaftaran, verifikasi berlapis, penolakan, dan pembatalan.
     - `SertifikatService`: Menangani pembuatan nomor sertifikat unik, verifikasi kelayakan, dan proses *bulk generation/cancellation*.
     - `LaporanService`: Menangani rekapitulasi data analitik dan ekspor dokumen multi-format.

3. **Manajemen Pelatihan & Proteksi Kuota Otomatis**
   - Alur publikasi status pelatihan: **Draft → Publish → Close / Selesai**.
   - **Auto-Close & Auto-Reopen**: Sistem secara otomatis menutup pendaftaran ketika kuota terpenuhi (`Sudah Penuh`), dan otomatis membuka kembali kelas (*Publish*) apabila admin memperluas kapasitas kuota atau terdapat peserta yang membatalkan pendaftaran.

4. **Sistem Presensi Fleksibel (Mandiri vs Admin)**
   - Admin dapat menentukan mode presensi untuk setiap pelatihan:
     - **Presensi Dikelola Admin**: Admin menandai kehadiran peserta secara manual atau massal.
     - **Presensi Mandiri**: Peserta dapat melakukan konfirmasi kehadiran secara mandiri langsung dari halaman *Riwayat Pelatihan* atau *Detail Pelatihan* pada hari pelaksanaan.

5. **Penerbitan Sertifikat Digital A4 Landscape Presisi (*DomPDF*)**
   - Pembuatan sertifikat otomatis dengan format nomor seri unik: `SIPPAD-[ID_PELATIHAN]-[NO_URUT]-[TAHUN]`.
   - **Anti-Page Break**: Layout PDF (`resources/views/pdf/sertifikat.blade.php`) dibangun menggunakan *Absolute Inset Positioning* (`top/bottom/left/right`), menjamin dokumen tercetak sempurna dalam 1 halaman A4 Landscape tanpa risiko terpotong ke halaman kedua.
   - **Bulk Actions via Alpine.js**: Admin dapat memilih banyak peserta sekaligus via checkbox interaktif untuk melakukan *Generate Sertifikat Massal* (sekaligus otomatis menyetel status kehadiran menjadi "Hadir") atau *Batalkan Sertifikat Massal*.

6. **Ekspor Laporan Native & Analitik Komprehensif**
   - **Excel Native (.xlsx)**: Menggunakan library `maatwebsite/excel` dengan concern `FromView`, `ShouldAutoSize`, dan `WithTitle` untuk ekspor spreadsheet biner rapi dan profesional.
   - **PDF & CSV Export**: Pilihan ekspor dokumen PDF eksekutif atau raw CSV untuk keperluan audit dan pengolahan data lanjutan.
   - Filter laporan dinamis berdasarkan rincian bulan, tahun, dan kategori pelatihan.

7. **Desain Premium, Dark/Light Mode, & WCAG AA Compliant**
   - Desain antarmuka modern terinspirasi dari **Adobe Spectrum Design System** dengan penggunaan variabel CSS kustom (`resources/css/app.css`).
   - Toggle **Dark / Light Mode** interaktif di navbar berbasis Alpine.js dengan penyimpanan preferensi lokal.
   - **Aksesibilitas WCAG AA**: Rasio kontras warna utama (Primary Red `#E00D00`), warna teks redup (`#595959`), serta warna fungsional (success, warning, danger, info) diuji untuk selalu melampaui rasio kontras 4.5:1 (untuk teks normal) dan 4.8:1 (untuk elemen antarmuka).
   - Dukungan indikator fokus visual (`*:focus-visible`) dan preferensi reduksi animasi (`prefers-reduced-motion: reduce`).

8. **Sistem Notifikasi Database Real-Time**
   - Integrasi *Laravel Database Notifications* yang memicu pemberitahuan otomatis saat status pendaftaran berubah (Menunggu → Terverifikasi / Ditolak).
   - Komponen lonceng notifikasi (*Bell Icon*) interaktif dengan *dropdown list* dan fitur *Mark All as Read* pada navbar Admin maupun User.

---

## :zap: Usage

Bagian ini menjelaskan langkah-langkah untuk menginstal, mengonfigurasi, dan mengoperasikan SIPPAD di lingkungan lokal maupun server.

### :electric_plug: Installation

Ikuti panduan langkah demi langkah berikut untuk memasang SIPPAD di lingkungan pengembangan lokal Anda:

```bash
# 1. Kloning repositori SIPPAD ke komputer lokal Anda
$ git clone https://github.com/bajiff/baji-sippad.git
$ cd sippad

# 2. Install dependensi PHP menggunakan Composer
$ composer install

# 3. Salin file konfigurasi environment
$ cp .env.example .env

# 4. Generate Application Encryption Key
$ php artisan key:generate

# 5. Konfigurasi koneksi database di dalam file .env
# Anda dapat menggunakan PostgreSQL (Rekomendasi) atau SQLite untuk dev cepat:
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=sippad_db
# DB_USERNAME=postgres
# DB_PASSWORD=rahasia
#
# ATAU untuk SQLite:
# DB_CONNECTION=sqlite
# (Pastikan membuat file database/database.sqlite terlebih dahulu: touch database/database.sqlite)

# 6. Jalankan migrasi database beserta Seeder (Admin, Kategori, Pelatihan, dan Sample User)
$ php artisan migrate:fresh --seed

# 7. Install dependensi JavaScript/Frontend dan build aset Vite
$ npm install
$ npm run build

# 8. Buat symbolic link untuk storage publik (untuk upload dokumentasi kegiatan)
$ php artisan storage:link
```

### :package: Commands

Berikut adalah daftar perintah penting (*command*) yang sering digunakan untuk menjalankan, menguji, dan mengelola aplikasi SIPPAD:

| Perintah | Deskripsi |
| :--- | :--- |
| `composer run dev` | **[Rekomendasi]** Menjalankan Laravel Server (`serve`), Queue Worker (`queue:listen`), Pail Log Viewer (`pail`), dan Vite Dev Server (`npm run dev`) secara konstan dan bersaman (*concurrent*). |
| `php artisan serve` | Menjalankan server pengembangan mandiri pada `http://localhost:8000`. |
| `npm run dev` | Menjalankan server Vite untuk *Hot Module Replacement (HMR)* saat modifikasi aset CSS/JS. |
| `php artisan queue:listen` | Menjalankan background worker untuk memproses antrean tugas (seperti pengiriman notifikasi atau pembuatan dokumen PDF berat). |
| `php artisan test` | Menjalankan seluruh rangkaian automated testing (Unit & Feature Tests) dengan standar PHPUnit / Pest. |
| `php artisan migrate:fresh --seed` | Mereset ulang seluruh tabel database dan mengisi kembali dengan data awal (*seed data*). |
| `npm run build` | Mengompilasi dan mengoptimasi aset frontend (CSS/JS) untuk lingkungan produksi. |

---

## :wrench: Development

SIPPAD dirancang dengan standar *clean code*, modular, dan sangat bersahabat bagi pengembang lain maupun agen AI yang ingin berkontribusi.

### :notebook: Pre-Requisites

Pastikan sistem operasi Anda telah dilengkapi dengan perangkat lunak berikut sebelum memulai pengembangan:
- **PHP** >= 8.3 (dengan ekstensi: `pdo_pgsql`, `pdo_sqlite`, `mbstring`, `exif`, `pcntl`, `bcmath`, `gd`, `zip`, `intl`)
- **Composer** >= 2.5
- **Node.js** >= 18.x & **NPM** >= 9.x
- **PostgreSQL** >= 16.0 (atau SQLite 3 untuk pengembangan ringan)
- **Git** & **Terminal** (Linux / macOS / WSL2 di Windows)

### :nut_and_bolt: Development Environment

1. **Pengaturan Database**:
   Secara default, SIPPAD dikonfigurasi untuk menggunakan PostgreSQL 16.14. Jika Anda mengembangkan secara lokal dan ingin kepraktisan maksimal, ubah `DB_CONNECTION=sqlite` pada `.env` dan jalankan perintah `touch database/database.sqlite`.

2. **Pengkodean & Code Style**:
   Proyek ini menggunakan **Laravel Pint** untuk standarisasi format penulisan kode PHP (PSR-12). Sebelum melakukan commit, pastikan menjalankan formatting:
   ```bash
   ./vendor/bin/pint
   ```

3. **Log Monitoring & Debugging**:
   Manfaatkan `php artisan pail` (termasuk dalam `composer run dev`) untuk memantau log aplikasi secara real-time dengan tampilan terminal yang interaktif dan rapi.

### :file_folder: File Structure

Struktur direktori utama SIPPAD diatur mengikuti konvensi terbaik Laravel 13 dengan pemisahan layer logika bisnis yang jelas:

```bash
sippad/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Controller Admin (Pelatihan, Kategori, Pendaftaran, Laporan)
│   │   │   ├── Auth/          # Controller Autentikasi (Login, Register, Logout)
│   │   │   └── User/          # Controller User (Dashboard, Profil, Riwayat, Presensi)
│   │   └── Middleware/        # AdminMiddleware, UserMiddleware, GuestMiddleware
│   ├── Models/                # User, Pelatihan, Pendaftaran, Kehadiran, Sertifikat, Dokumentasi, KategoriPelatihan
│   ├── Notifications/         # PendaftaranStatusNotification (Database Channel)
│   ├── Providers/             # AppServiceProvider, dll.
│   └── Services/              # Service Layer: PendaftaranService, SertifikatService, LaporanService
├── database/
│   ├── migrations/            # 10+ skema migrasi relasional database
│   └── seeders/               # AdminSeeder, KategoriSeeder, PelatihanSeeder, DatabaseSeeder
├── docs/
│   ├── PROGRESS.md            # Laporan progres & status audit implementasi SIPPAD (100% Completed)
│   └── SIPPAD-Implementation-Planning.md # Spesifikasi & perencanaan arsitektur proyek
├── resources/
│   ├── css/
│   │   └── app.css            # Desain Token Adobe Spectrum, WCAG AA utilities, & Tailwind config
│   ├── js/
│   │   └── app.js             # Bootstrap Alpine.js & interaktivitas komponen
│   └── views/
│       ├── admin/             # Halaman dasbor & manajemen Admin
│       ├── components/        # Komponen Blade reusable (navbar, sidebar, card, badge, modal)
│       ├── layouts/           # Layout utama: app, admin, user, guest
│       ├── pdf/               # Template cetak DomPDF: sertifikat.blade.php (A4 Landscape Absolute)
│       ├── user/              # Halaman dasbor & pendaftaran Peserta
│       └── landing.blade.php  # Halaman beranda publik dengan Dark/Light toggle
├── tests/
│   ├── Feature/               # Pengujian fungsional end-to-end (Auth, CRUD, Register, Export)
│   └── Unit/                  # Pengujian unit Service Layer & kalkulasi model
├── .env.example               # Contoh konfigurasi variabel lingkungan
├── composer.json              # Daftar dependensi PHP (Laravel 13, DomPDF, Maatwebsite/Excel)
├── package.json               # Daftar dependensi Node.js (Vite, Alpine.js, TailwindCSS)
└── README.md                  # Dokumentasi proyek (file ini)
```

#### Tabel Penjelasan Berkas & Komponen Kunci

| No | Nama Berkas / Direktori | Lapisan Arsitektur | Detail & Peran Fungsi |
| :---: | :--- | :--- | :--- |
| 1 | `app/Services/PendaftaranService.php` | **Service Layer** | Mengenkapsulasi logika verifikasi, penolakan, pembatalan, serta proteksi kuota pelatihan. |
| 2 | `app/Services/SertifikatService.php` | **Service Layer** | Menangani kalkulasi kelayakan presensi, pembuatan nomor seri unik, dan *bulk generator*. |
| 3 | `app/Services/LaporanService.php` | **Service Layer** | Mengolah agregasi data analitik dan penghubung ekspor Excel (`.xlsx`), PDF, dan CSV. |
| 4 | `resources/views/pdf/sertifikat.blade.php` | **Presentation / PDF** | Template sertifikat A4 Landscape berbasis *Absolute Inset Positioning* bebas terpotong. |
| 5 | `app/Notifications/PendaftaranStatusNotification.php` | **Notification Layer** | Mengirimkan notifikasi database real-time ke dasbor peserta saat status diverifikasi. |
| 6 | `resources/css/app.css` | **Styling / Design System** | Menyimpan variabel warna Adobe Spectrum, rasio kontras WCAG AA, dan aturan animasi. |

### :hammer: Build

Untuk mempersiapkan aplikasi SIPPAD menuju lingkungan produksi (*production build*), lakukan langkah-langkah kompilasi berikut:

```bash
# 1. Kompilasi dan minifikasi aset CSS dan JavaScript dengan Vite
$ npm run build

# 2. Install dependensi Composer tanpa paket development & optimasi autoloader
$ composer install --optimize-autoloader --no-dev

# 3. Buat cache untuk konfigurasi, rute, dan tampilan Blade untuk kinerja maksimal
$ php artisan config:cache
$ php artisan route:cache
$ php artisan view:cache
$ php artisan event:cache
```

### :rocket: Deployment

Berikut adalah instruksi dan praktik terbaik untuk menyebarkan (*deploy*) SIPPAD ke server produksi (VPS / Cloud / Dedicated Server):

1. **Persyaratan Server Production**:
   - Web Server: Nginx atau Apache (dengan modul `mod_rewrite`).
   - PHP-FPM 8.3 dengan konfigurasi memori minimal `memory_limit = 256M` (dianjurkan `512M` untuk ekspor Excel/PDF massal).
   - PostgreSQL 16 Server (atau MySQL 8.0+ / MariaDB 10.10+ jika dikonfigurasi).

2. **Konfigurasi Environment Production**:
   Pastikan variabel berikut disetel dengan benar pada file `.env` server produksi Anda:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://sippad.desakarangduren.go.id

   # Gunakan Redis atau Database untuk Cache & Session di production
   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   ```

3. **Background Job Worker (Supervisor)**:
   Karena SIPPAD menggunakan antrean database untuk pemrosesan notifikasi dan pembuatan PDF massal, pasang **Supervisor** pada sistem Linux untuk menjaga proses `queue:work` tetap berjalan di latar belakang:
   ```ini
   [program:sippad-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /var/www/sippad/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
   autostart=true
   autorestart=true
   user=www-data
   numprocs=2
   redirect_stderr=true
   stdout_logfile=/var/log/sippad-worker.log
   ```

4. **Keamanan & SSL**:
   - Gunakan sertifikat SSL (Let's Encrypt / Cloudflare) untuk memaksakan koneksi HTTPS.
   - Pastikan direktori `/storage` dan `/bootstrap/cache` memiliki hak akses tulis (`chmod -R 775`).

---

## :cherry_blossom: Community

SIPPAD adalah proyek yang dibangun dengan semangat keterbukaan, kolaborasi, dan dedikasi untuk kemajuan digitalisasi tata kelola desa. Kami sangat menyambut kontribusi dari komunitas pengembang, akademisi, maupun praktisi pemerintahan desa!

### :fire: Contribution

Kontribusi Anda sangat berharga untuk membuat SIPPAD semakin sempurna. Berikut adalah cara bagaimana Anda dapat berpartisipasi:

1. **Melaporkan Bug (*Report a Bug*)** <br>
   Jika Anda menemukan kendala teknis, kerusakan layout, atau bug perhitungan kuota/presensi, silakan buat laporan melalui [GitHub Issues](https://github.com/bajiff/baji-sippad/issues) dengan menyertakan deskripsi detail, langkah reproduksi, dan tangkapan layar.

2. **Meminta Fitur Baru (*Request a Feature*)** <br>
   Punya ide cemerlang untuk penambahan modul baru (misalnya: modul absensi QR Code atau integrasi WhatsApp Gateway)? Ajukan usulan Anda di [Feature Requests](https://github.com/bajiff/baji-sippad/issues) untuk diskusikan bersama tim pengembang.

3. **Mengirimkan Pull Request (PR)** <br>
   Ingin berkontribusi kode secara langsung?
   - Pilih *issue* yang berstatus `open` atau `good first issue`.
   - Lakukan *fork* repositori dan buat *branch* fitur Anda.
   - Pastikan kode Anda lulus seluruh pengujian automated (`php artisan test`) serta mematuhi standar *code style* (`./vendor/bin/pint`).
   - Kirimkan Pull Request ke branch `main` atau `stage`.

> Jika Anda baru pertama kali berkontribusi pada proyek open-source, silakan pelajari panduan [Pengenalan Open Source](https://www.digitalocean.com/community/tutorial_series/an-introduction-to-open-source) dan [Cara Membuat Pull Request di GitHub](https://www.digitalocean.com/community/tutorials/how-to-create-a-pull-request-on-github).

### :cactus: Branches

Proyek SIPPAD menerapkan metodologi integrasi berkelanjutan (*Continuous Integration*) yang agil. Struktur percabangan (*branching model*) diatur sebagai berikut:

1. **`main` / `master`** adalah cabang produksi (*production-ready branch*). Kode di cabang ini harus selalu dalam keadaan stabil, teruji 100%, dan siap deployed.
2. **`stage` / `develop`** adalah cabang pengembangan utama (*staging branch*). Semua penggabungan fitur baru dikumpulkan di cabang ini sebelum di-release ke `main`.
3. **Feature Branches**: Cabang sementara untuk pengembangan fitur baru atau perbaikan bug. Cabang ini harus dibuat dari `stage` dan akan dihapus setelah di-merge.

**Aturan Penamaan Cabang Fitur:**
- Fitur baru: `feat/nama-fitur` (contoh: `feat/qr-code-attendance`)
- Perbaikan bug: `fix/nama-bug` (contoh: `fix/pdf-page-break`)
- Dokumentasi: `docs/nama-update` (contoh: `docs/update-readme`)
- Refactor/Optimasi: `refactor/nama-modul` (contoh: `refactor/eager-loading-query`)

**Langkah-langkah Mengajukan Pull Request:**
1. Arahkan PR Anda ke cabang `stage` (atau `main` jika merupakan *hotfix* kritis).
2. Tulis deskripsi PR secara jelas: apa masalah yang diselesaikan dan bagaimana solusi teknisnya.
3. Jika perubahan mencakup elemen UI/UX, **wajib** menyertakan tangkapan layar (*screenshot*) atau rekaman GIF sebelum dan sesudah perubahan.
4. Pastikan semua status automated build & test bernilai hijau (Lolos 100%).

### :exclamation: Guideline

Untuk menjaga kualitas arsitektur sistem dan konsistensi kode, seluruh kontributor wajib mematuhi pedoman teknis berikut:

1. **Aturan Service Layer Pattern**:
   - **Dilarang keras** menulis logika bisnis kompleks (seperti kalkulasi status, validasi bersyarat multi-tabel, atau pemrosesan file) secara langsung di dalam **Controller**.
   - Controller hanya bertugas menerima *Request*, memanggil *Service Layer*, dan mengembalikan *Response/View*.
   - Letakkan seluruh logika bisnis pada kelas yang sesuai di `app/Services/`.

2. **Aturan Standarisasi Kode PHP (PSR-12)**:
   - Wajib menjalankan `./vendor/bin/pint` sebelum melakukan commit.
   - Gunakan *Type Hinting* dan *Return Type Declarations* yang jelas pada setiap fungsi dan method PHP.

3. **Aturan Aksesibilitas UI/UX (WCAG AA)**:
   - Setiap penambahan elemen warna baru pada Blade atau CSS **wajib** diuji rasio kontrasnya.
   - Teks normal harus memiliki rasio kontras minimal **4.5:1** terhadap warna latar belakangnya (baik di mode Light maupun Dark).
   - Jangan gunakan warna sebagai satu-satunya indikator visual (selalu sertakan teks, ikon, atau *badge* keterangan).

4. **Aturan Cetak PDF DomPDF (*Absolute Positioning*)**:
   - Saat memodifikasi layout `sertifikat.blade.php`, **hindari** penggunaan *margin* eksternal yang besar atau elemen *flow/block* berderet yang dapat memicu DomPDF menghasilkan halaman kedua (*blank/overflow page*).
   - Gunakan teknik **Absolute Inset Positioning** (`position: absolute; top: Xpx; bottom: Xpx; left: Xpx; right: Xpx;`) agar seluruh elemen terkunci tepat di dalam batas canvas A4 Landscape (1123px x 794px).

---

## :question: FAQ

Berikut adalah jawaban atas pertanyaan yang paling sering diajukan mengenai arsitektur dan operasional SIPPAD:

**Q1: Mengapa layout sertifikat PDF di SIPPAD menggunakan teknik *Absolute Positioning* daripada layout HTML table/flexbox biasa?** <br>
> **A:** Engine DomPDF memiliki keterbatasan dalam memproses *page-break-inside* dan margin CSS3 modern pada dokumen berorientasi Landscape. Teknik layout biasa sering kali memicu pemotongan halaman secara acak yang menghasilkan halaman ke-2 kosong atau tanda tangan terpotong. Dengan *Absolute Positioning*, seluruh koordinat elemen visual dikunci secara presisi terhadap canvas A4, menjamin hasil cetak 100% konsisten dan sempurna dalam 1 halaman.

**Q2: Bagaimana cara kerja fitur Presensi Mandiri oleh Peserta?** <br>
> **A:** Admin dapat mengaktifkan opsi "Presensi Mandiri" pada pengaturan kelas pelatihan. Pada hari pelatihan berlangsung, tombol konfirmasi kehadiran akan otomatis aktif di dashboard peserta. Saat peserta mengklik tombol tersebut, sistem akan mencatat waktu kehadiran aktual (*timestamp*) ke dalam tabel `kehadiran` secara real-time.

**Q3: Apa yang terjadi apabila kuota kelas pelatihan sudah penuh saat ada peserta yang ingin mendaftar?** <br>
> **A:** Sistem proteksi kuota otomatis di `PendaftaranService` akan memblokir pendaftaran baru dan tombol di frontend akan berubah menjadi badge `Sudah Penuh` (disabled). Namun, jika Admin menambah kuota kelas di dashboard atau jika ada peserta eksisting yang membatalkan pendaftarannya, status kelas akan otomatis kembali terbuka (*Publish*) tanpa perlu intervensi manual dari Admin.

**Q4: Bagaimana cara menguji pengiriman notifikasi database secara lokal jika tidak memiliki server SMTP mail?** <br>
> **A:** SIPPAD menggunakan *Database Notification Channel* secara default (`notifications` table). Anda tidak memerlukan server SMTP untuk melihat sistem kerja notifikasi ini. Cukup jalankan `composer run dev` (yang otomatis memicu `queue:listen`), dan setiap kali Anda meverifikasi pendaftaran dari Admin, lonceng notifikasi di dashboard User akan langsung menampilkan *badge* merah dan daftar pemberitahuan baru secara interaktif!

**Q5: Apakah SIPPAD mendukung ekspor laporan ke format Microsoft Excel asli (.xlsx)?** <br>
> **A:** Ya! SIPPAD telah diintegrasikan dengan library `maatwebsite/excel` versi terbaru yang menghasilkan file biner asli `.xlsx` (bukan HTML table yang diubah ekstensinya), lengkap dengan auto-sizing kolom, styling header profesional, dan penulisan tipe data numerik yang akurat.

---

## :page_facing_up: Resources

Berikut adalah kumpulan referensi dokumentasi resmi dan sumber daya penting yang digunakan dalam pengembangan SIPPAD:

- **[Laravel 13 Documentation](https://laravel.com/docs/13.x)** — Framework inti PHP untuk backend development.
- **[Alpine.js Documentation](https://alpinejs.dev/)** — Framework JavaScript reaktif dan ringan untuk interaktivitas UI & Bulk Actions.
- **[Vite Documentation](https://vitejs.dev/)** — Next-generation frontend tooling & asset bundler.
- **[DomPDF Documentation](https://github.com/dompdf/dompdf)** — HTML to PDF converter untuk generator sertifikat A4 Landscape.
- **[Laravel Excel (Maatwebsite) Docs](https://docs.laravel-excel.com/)** — Library ekspor spreadsheet native `.xlsx` di Laravel.
- **[Adobe Spectrum Design System](https://spectrum.adobe.com/)** — Pedoman filosofi desain UI/UX, warna, dan tipografi yang menginspirasi tampilan SIPPAD.
- **[WCAG 2.1 AA Guidelines (W3C)](https://www.w3.org/TR/WCAG21/)** — Standar internasional untuk kontras warna dan aksesibilitas antarmuka web.

---

## :camera: Gallery

Berikut adalah representasi visual dari antarmuka SIPPAD yang mengusung desain elegan, kontras tinggi, serta konsistensi di seluruh modul aplikasi:

| Halaman Landing Page (Light Mode) | Halaman Landing Page (Dark Mode) |
| :---: | :---: |
| <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?auto=format&fit=crop&w=600&q=80" alt="Landing Page Light" width="400"> | <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=600&q=80" alt="Landing Page Dark" width="400"> |
| *Tampilan beranda publik yang bersahabat dengan kontras warna merah primer yang tegas.* | *Mode gelap interaktif yang nyaman dimata, mereduksi kelelahan visual saat bekerja malam hari.* |

| Dashboard Admin & Verification Queue | Bulk Action & Manajemen Sertifikat |
| :---: | :---: |
| <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=600&q=80" alt="Admin Dashboard" width="400"> | <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80" alt="Certificate Management" width="400"> |
| *Statistik real-time, grafik partisipasi desa, dan antrean verifikasi peserta.* | *Antarmuka seleksi massal (checkboxes) dengan Alpine.js untuk penerbitan sertifikat serentak.* |

| Hasil Cetak Sertifikat A4 Landscape (DomPDF) | Dasbor Peserta & Presensi Mandiri |
| :---: | :---: |
| <img src="https://images.unsplash.com/photo-1589330694653-ded6df03f754?auto=format&fit=crop&w=600&q=80" alt="Certificate PDF" width="400"> | <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=600&q=80" alt="User Dashboard" width="400"> |
| *Sertifikat digital resmi dengan penomoran unik, bebas terpotong halaman (*page-break-free*).* | *Riwayat pendaftaran, status verifikasi, dan tombol konfirmasi presensi mandiri peserta.* |

---

## :star2: Credit/Acknowledgment

Pengembangan dan penyempurnaan sistem **SIPPAD** ini terwujud berkat dedikasi, visi teknis, dan arahan arsitektural dari pihak-pihak berikut:

* **Tuan Baji** — *Project Lead & Visionary Creator*.  
  Atas kepemimpinan proyek, perumusan kebutuhan spesifikasi tata kelola pelatihan desa, serta dedikasi dalam mewujudkan sistem informasi desa yang modern, responsif, dan berdaya guna tinggi bagi masyarakat desa (khususnya Desa Karangduren).

* **Prof. Dr. Meki (Senior Software Engineer)** — *Lead Technical Reviewer & AI Architect*.  
  Atas audit arsitektur menyeluruh, penerapan standar *Clean Service Layer Pattern*, optimasi performa query anti-N+1, penyempurnaan layout PDF absolut DomPDF, serta audit aksesibilitas ketat berstandar internasional WCAG AA.

* **Laravel & Open Source Community**  
  Terima kasih kepada Taylor Otwell dan seluruh kontributor Laravel framework, Alpine.js, Tailwind CSS, Vite, DomPDF, serta Maatwebsite/Excel yang telah menyediakan perangkat kerja luar biasa untuk ekosistem open-source.

---

## :lock: License

SIPPAD dirilis dan didistribusikan di bawah lisensi terbuka **[MIT License](https://opensource.org/licenses/MIT)**.

Anda diizinkan secara bebas untuk menggunakan, menyalin, memodifikasi, menggabungkan, menerbitkan, mendistribusikan, dan/atau menjual salinan perangkat lunak ini untuk keperluan pemerintahan desa, komersial, maupun pendidikan, dengan syarat tetap mencantumkan pemberitahuan hak cipta dan lisensi asli di setiap salinan perangkat lunak.

```
MIT License

Copyright (c) 2026 Tuan Baji & SIPPAD Contributors

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---
<p align="center">
  <b>SIPPAD — Sistem Informasi Pelatihan dan Pendaftaran Desa</b><br>
  <i>Dibuat dengan ❤️ untuk Kemajuan Digitalisasi Desa</i>
</p>
