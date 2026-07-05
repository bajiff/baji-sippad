# Data Flow Diagram (DFD) Level 0 (Context Diagram)

DFD Level 0 hanya memperlihatkan hubungan antara **entitas eksternal** dengan **SIPPAD** sebagai satu proses besar.

```text
                    +----------------------+
                    |        ADMIN         |
                    +----------+-----------+
                               |
      Kelola Pelatihan, Verifikasi Peserta,
      Kehadiran, Dokumentasi, Laporan
                               |
                               ▼
        +--------------------------------------+
        |              SIPPAD                  |
        | Sistem Pendaftaran Pelatihan Anak    |
        |              Desa                    |
        +--------------------------------------+
                               ▲
                               |
 Registrasi, Login, Pendaftaran Pelatihan,
 Status Pendaftaran, Riwayat, Sertifikat
                               |
                    +----------+-----------+
                    |         USER         |
                    +----------------------+
```

---

# DFD Level 1

Pada Level 1, sistem dipecah menjadi beberapa proses utama.

```text
                     +-----------+
                     |   USER    |
                     +-----+-----+
                           |
         Registrasi/Login/Pendaftaran
                           |
                           ▼
                 (1.0 Authentication)
                           |
                           ▼
                     D1 Data User
                           |
                           ▼
                (2.0 Kelola Pelatihan)
                           |
                           ▼
                  D2 Data Pelatihan
                           |
                           ▼
               (3.0 Pendaftaran Peserta)
                           |
                           ▼
                D3 Data Pendaftaran
                           |
                           ▼
                  +----------------+
                  |     ADMIN      |
                  +--------+-------+
                           |
                           ▼
               (4.0 Verifikasi Peserta)
                           |
                           ▼
                D3 Data Pendaftaran
                           |
                           ▼
               (5.0 Kelola Kehadiran)
                           |
                           ▼
                 D4 Data Kehadiran
                           |
                           ▼
             (6.0 Generate Sertifikat)
                           |
                           ▼
                 D5 Data Sertifikat
                           |
                           ▼
                  Riwayat Pelatihan
```

---

# DFD Level 2 Proses Authentication (1.0)

```text
               USER
                 │
                 ▼
      Input Email & Password
                 │
                 ▼
      (1.1 Validasi Login)
                 │
        ┌────────┴─────────┐
        ▼                  ▼
     Valid             Tidak Valid
        │                  │
        ▼                  ▼
 Dashboard          Pesan Error
        │
        ▼
    Data User
```

---

# DFD Level 2 Proses Kelola Pelatihan (2.0)

```text
                ADMIN
                  │
                  ▼
         Input Data Pelatihan
                  │
                  ▼
        (2.1 CRUD Pelatihan)
                  │
                  ▼
          Data Pelatihan
                  │
                  ▼
             DATABASE
                  │
                  ▼
      Ditampilkan ke Dashboard User
```

---

# DFD Level 2 Proses Pendaftaran (3.0)

```text
                 USER
                  │
                  ▼
        Memilih Pelatihan
                  │
                  ▼
         Klik Daftar Pelatihan
                  │
                  ▼
      (3.1 Simpan Pendaftaran)
                  │
                  ▼
        Data Pendaftaran
                  │
                  ▼
              DATABASE
                  │
                  ▼
      Status = Pending Verifikasi
```

---

# DFD Level 2 Proses Verifikasi (4.0)

```text
                ADMIN
                  │
                  ▼
      Melihat Data Pendaftaran
                  │
                  ▼
        (4.1 Verifikasi Data)
                  │
        ┌─────────┴─────────┐
        ▼                   ▼
    Disetujui           Ditolak
        │                   │
        ▼                   ▼
 Update Status        Update Status
        │                   │
        ▼                   ▼
      DATABASE          DATABASE
        │
        ▼
 Status Ditampilkan ke User
```

---

# DFD Level 2 Proses Kehadiran (5.0)

```text
               ADMIN
                 │
                 ▼
      Input Kehadiran Peserta
                 │
                 ▼
       (5.1 Absensi Peserta)
                 │
                 ▼
          Data Kehadiran
                 │
                 ▼
             DATABASE
```

---

# DFD Level 2 Proses Sertifikat (6.0)

```text
              Data Kehadiran
                    │
                    ▼
        (6.1 Cek Status Hadir)
                    │
         ┌──────────┴──────────┐
         ▼                     ▼
      Hadir              Tidak Hadir
         │                     │
         ▼                     ▼
 Generate Sertifikat     Tidak Generate
         │
         ▼
   Data Sertifikat
         │
         ▼
     DATABASE
         │
         ▼
   User Mengunduh Sertifikat
```

---

# Data Store (Penyimpanan Data)

|Kode|Nama Data Store|Keterangan|
|---|---|---|
|**D1**|Data User|Menyimpan akun peserta|
|**D2**|Data Pelatihan|Menyimpan informasi pelatihan|
|**D3**|Data Pendaftaran|Menyimpan data pendaftaran peserta|
|**D4**|Data Kehadiran|Menyimpan absensi peserta|
|**D5**|Data Sertifikat|Menyimpan sertifikat peserta|
|**D6**|Data Dokumentasi|Menyimpan dokumentasi kegiatan|
|**D7**|Data Kategori|Menyimpan kategori pelatihan|

---

# Entitas Eksternal

## User

Mengirim data:

- Registrasi
    
- Login
    
- Pendaftaran Pelatihan
    

Menerima data:

- Informasi Pelatihan
    
- Status Pendaftaran
    
- Sertifikat
    
- Riwayat Pelatihan
    

---

## Admin

Mengirim data:

- Data Pelatihan
    
- Verifikasi Peserta
    
- Kehadiran
    
- Dokumentasi
    

Menerima data:

- Data Peserta
    
- Statistik
    
- Laporan
    
- Rekap Kehadiran
    

---

# Ringkasan Proses DFD SIPPAD

|Proses|Nama Proses|
|---|---|
|**1.0**|Authentication|
|**2.0**|Kelola Pelatihan|
|**3.0**|Pendaftaran Peserta|
|**4.0**|Verifikasi Peserta|
|**5.0**|Kelola Kehadiran|
|**6.0**|Generate Sertifikat|
|**7.0**|Generate Laporan|

## Rekomendasi untuk dokumentasi skripsi atau proyek

Agar dokumentasi SIPPAD lebih sistematis, susunan analisis dan perancangan dapat dibuat sebagai berikut:

1. **Flowchart Sistem**
    
2. **Flowmap Sistem**
    
3. **Data Flow Diagram (DFD) Level 0**
    
4. **Data Flow Diagram (DFD) Level 1**
    
5. **Data Flow Diagram (DFD) Level 2** untuk setiap proses utama (Authentication, Kelola Pelatihan, Pendaftaran, Verifikasi, Kehadiran, Sertifikat, dan Laporan)
    
6. **Entity Relationship Diagram (ERD)**
    
7. **Rancangan Arsitektur Sistem**
    

Urutan tersebut membuat alur analisis bergerak dari gambaran umum hingga detail implementasi data, sekaligus konsisten dengan rancangan SIPPAD yang telah kita susun bersama.