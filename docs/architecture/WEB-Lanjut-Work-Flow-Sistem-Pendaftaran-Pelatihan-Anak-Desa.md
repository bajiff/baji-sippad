# Work Flow Sistem Pendaftaran Pelatihan Anak Desa berbasis Web Laravel

## Flow Admin SIPPAD (Sistem Pendaftaran Pelatihan Anak Desa)

Mulai
  │
  ▼
Login Admin
  │
  ▼
Validasi Username & Password
  │
  ├─────────────── Tidak Valid ────────────────┐
  │                                            │
  ▼                                            │
Dashboard Admin ◄──────────────────────────────┘
  │
  ├──────────────────────────────────────────────────┐
  │                                                  │
  ▼                                                  ▼
Kelola Pelatihan                             Kelola Peserta
  │                                                  │
  ▼                                                  ▼
Tambah/Edit/Hapus Pelatihan                 Melihat Data Peserta
  │                                                  │
  ▼                                                  ▼
Isi Detail Pelatihan                      Melihat Riwayat Pelatihan
(Judul, Deskripsi, Kuota,
Tanggal, Lokasi, Poster)
  │
  ▼
Publikasikan Pelatihan
  │
  ▼
Pelatihan Tampil di Dashboard User
  │
  ▼
Menunggu Pendaftaran Peserta
  │
  ▼
Melihat Daftar Pendaftar
  │
  ▼
Verifikasi Pendaftaran
  │
  ├───────────────┬────────────────
  │               │
  ▼               ▼
Setujui         Tolak
  │               │
  ▼               ▼
Status         Status
Disetujui      Ditolak
  │               │
  │               ▼
  │          Kirim Notifikasi
  │
  ▼
Cek Kuota Pelatihan
  │
  ├─────────────── Kuota Penuh ───────────────┐
  │                                           │
  ▼                                           ▼
Tutup Pendaftaran                      Tetap Membuka
  │                                    Pendaftaran
  │                                           │
  └──────────────────────┬────────────────────┘
                         ▼
               Hari Pelaksanaan Tiba
                         │
                         ▼
             Input Kehadiran Peserta
                         │
                         ▼
          Pelatihan Berlangsung/Selesai
                         │
                         ▼
     Upload Dokumentasi / Materi Pelatihan
                         │
                         ▼
(Optional) Generate Sertifikat Peserta
                         │
                         ▼
        Arsipkan Data Pelatihan Selesai
                         │
                         ▼
          Generate Laporan Pelatihan
                         │
                         ▼
                      Logout
                         │
                         ▼
                      Selesai






# Penjelasan Setiap Modul Admin

## 1. Login Admin

- Admin memasukkan email/username dan password.
- Sistem memvalidasi data.
- Jika gagal, kembali ke halaman login.
- Jika berhasil, masuk ke Dashboard Admin.

---

## 2. Dashboard Admin

Dashboard dapat menampilkan informasi seperti:

- Total Peserta
- Total Pelatihan Aktif
- Total Pelatihan Selesai
- Total Pendaftar
- Statistik bulanan

Contoh:
Dashboard

Total Peserta : 230
Total Pelatihan Aktif : 2
Total Pelatihan Selesai : 2
Total Pendaftar: 500
Menunggu Verifikasi : 32
Statistik minguan,bulanan,tahunan

# 3. Kelola Pelatihan

Admin dapat:

- Tambah Pelatihan
- Edit Pelatihan
- Hapus Pelatihan
- Tutup Pendaftaran
- Buka Pendaftaran

Data yang diinput:

- Judul*
- Deskripsi*
- Kategori*
- Lokasi*
- Tanggal*
- Jam*
- Narasumber*
- Kuota
- Persyaratan

Contoh:

```

- Judul: Pelatihan Membuat Desain Canva
- Deskripsi: Belajar membuat design canva pemula
- Kategori: Dasar
- Lokasi: Balai Desa
- Tanggal: 08/08/2026
- Jam: 13:00 WIB
- Narasumber: Baji Ajalah
- Kuota: 20 Orang
- Persyaratan: Punya HP/Laptop, Sudah Daftar Canva
```

# 4. Publish Pelatihan

Setelah selesai dibuat:

Draft
    │
    ▼
Publish
    │
    ▼
Tampil di Dashboard User

User baru bisa melihat pelatihan setelah status **Publish**.

---

# 5. Verifikasi Pendaftaran

Setelah user mendaftar:

Admin melihat daftar:

```
Nama
Umur
Alamat
Nomor HP
Tanggal Daftar
```

Kemudian admin memilih:

```
[Setujui]
atau
[Tolak]
```

Status berubah menjadi:

- Pending
- Disetujui
- Ditolak

---

# 6. Pengelolaan Kuota

Misal:
```
Kuota :50
Orang diterima: 50
Orang daftar: 50
Kuota penuh
Status: Closed
```
Pendaftaran otomatis ditutup.


---

# 7. Hari Pelaksanaan

Admin melihat daftar hadir.

Contoh:

```
□ Ahmad
☑ Budi
☑ Citra
☑ Dani
```

Admin dapat:

- Check-in peserta
- Input hadir
- Input tidak hadir

---

# 8. Dokumentasi

Setelah selesai:

Admin upload:

- Foto kegiatan
---

# 9. Sertifikat (Opsional)

Jika peserta hadir:

```
Peserta
      │
      ▼
Hadir?
      │
 ┌────┴────┐
 │         │
Ya       Tidak
 │         │
 ▼         ▼
Generate  Tidak
Sertifikat Mendapat
```

---

# 10. Laporan

Admin dapat melihat:

- Total peserta
- Total hadir
- Total tidak hadir
- Pelatihan selesai
- Pelatihan aktif

Laporan bisa difilter:

- Bulan
- Tahun
- Jenis pelatihan

Kemudian dapat diekspor ke:

- PDF
- Excel
- CSV

---

# ERD Sederhana yang Mendukung Flow Admin

```
Admin
   │
   │ membuat
   ▼
Pelatihan
   │
   │ memiliki
   ▼
Pendaftaran
   │
   │ dimiliki
   ▼
User
   │
   │ mengikuti
   ▼
Kehadiran
   │
   ▼
Sertifikat
```

## Rekomendasi fitur admin yang lengkap untuk SIPPAD:

1. Login Admin
2. Dashboard Statistik
3. Kelola Data Pelatihan
4. Kelola Kategori Pelatihan
5. Publish/Tutup Pelatihan
6. Kelola Pendaftaran Peserta
7. Verifikasi Peserta (Approve/Reject)
8. Pengelolaan Kuota
9. Manajemen Data Peserta
10. Absensi Kehadiran
11. Upload Dokumentasi Kegiatan
12. Generate Sertifikat (opsional)
13. Laporan dan Ekspor Data
14. Logout


## Flow User SIPPAD (Sistem Pendaftaran Pelatihan Anak Desa)

```text
Mulai
  │
  ▼
Registrasi Akun
  │
  ▼
Mengisi Data Diri
(Nama, Email, Password,
No HP, Alamat, dll)
  │
  ▼
Simpan Data
  │
  ▼
Login
  │
  ▼
Validasi Email & Password
  │
  ├────────────── Tidak Valid ──────────────┐
  │                                         │
  ▼                                         │
Dashboard User ◄────────────────────────────┘
  │
  ├───────────────────────────────┐
  │                               │
  ▼                               ▼
Lihat Profil                 Lihat Pelatihan
  │                               │
  ▼                               ▼
Edit Profil              Daftar Pelatihan Aktif
                                  │
                                  ▼
                      Memilih Salah Satu Pelatihan
                                  │
                                  ▼
                    Melihat Detail Pelatihan
      (Deskripsi, Jadwal, Lokasi, Kuota,
      Narasumber, Persyaratan)
                                  │
                                  ▼
                      Klik Tombol "Daftar"
                                  │
                                  ▼
                Konfirmasi Pendaftaran Pelatihan
                                  │
                                  ▼
                   Data Masuk ke Sistem Admin
                                  │
                                  ▼
                 Status = Menunggu Verifikasi
                                  │
                                  ▼
                  Admin Melakukan Verifikasi
                                  │
               ┌──────────────────┴──────────────────┐
               │                                     │
               ▼                                     ▼
        Disetujui Admin                     Ditolak Admin
               │                                     │
               ▼                                     ▼
 Status Berubah Menjadi                 Status Berubah Menjadi
      "Disetujui"                             "Ditolak"
               │                                     │
               ▼                                     ▼
Notifikasi Berhasil                  Notifikasi Penolakan
               │
               ▼
Menunggu Hari Pelaksanaan
               │
               ▼
Mengikuti Pelatihan
               │
               ▼
Admin Melakukan Absensi
               │
      ┌────────┴────────┐
      │                 │
      ▼                 ▼
    Hadir            Tidak Hadir
      │                 │
      ▼                 ▼
Mendapat Sertifikat   Tidak Mendapat
(Optional)            Sertifikat
      │
      ▼
Riwayat Pelatihan
      │
      ▼
Logout
      │
      ▼
Selesai
```

---

# Penjelasan Setiap Modul User

## 1. Registrasi Akun

Pengguna baru membuat akun dengan mengisi:

- Nama Lengkap
    
- Email
    
- Password
    
- Nomor HP
    
- Alamat
    
- Tanggal Lahir (opsional)
    

Setelah berhasil, akun dapat digunakan untuk login.

---

# 2. Login

User memasukkan:

- Email
    
- Password
    
- Jika benar maka masuk ke Dashboard.
    
- Jika salah maka sistem menampilkan pesan:

```
Email atau Password salah.
```

    Dan kembali ke halaman login.

---

# 3. Dashboard User

Dashboard menampilkan informasi seperti:

- Selamat Datang
    
- Jumlah Pelatihan Aktif
    
- Pelatihan Terbaru
    
- Status Pendaftaran Saya
    
- Riwayat Pelatihan
    

Contoh:

```
Halo, Ahmad

Pelatihan Aktif : 3
Pelatihan Terbaru (Dihitung dari terbitnya pelatihan sampai 1 bulan): 1
Pendaftaran Menunggu : 1
Pelatihan Disetujui : 2
```

---

# 4. Melihat Daftar Pelatihan

User dapat melihat seluruh pelatihan yang telah dipublikasikan oleh admin.

Contoh:

```
Pelatihan Microsoft Word
Kuota : 30

Microsoft Excel
Kuota : 20

Pelatihan Coding
Kuota : 10
```

Pelatihan yang sudah **Closed** tidak dapat didaftarkan.

---

# 5. Melihat Detail Pelatihan

Ketika user memilih pelatihan, sistem menampilkan informasi lengkap:

- Judul
    
- Deskripsi
    
- Narasumber
    
- Tanggal
    
- Jam
    
- Lokasi
    
- Kuota
    
- Persyaratan
    

Contoh:

```
Pelatihan Coding Dasar

Tanggal :
10 Juli 2026

Jam :
08.00 WIB

Lokasi :
Balai Desa

Kuota :
20 Orang

Persyaratan :
Memiliki HP atau Laptop
```

---

# 6. Mendaftar Pelatihan

User menekan tombol:

```
Daftar Pelatihan
```

Kemudian muncul konfirmasi:

```
Apakah Anda yakin ingin mendaftar?

[Ya]
[Tidak]
```

Jika memilih **Ya**, data pendaftaran dikirim ke sistem.

Status awal:

```
Pending
```

---

# 7. Menunggu Verifikasi

Karena admin melakukan proses verifikasi, maka user dapat melihat status:

```
Status Pendaftaran

● Pending
```

User tinggal menunggu keputusan admin.

---

# 8. Hasil Verifikasi

## Jika Disetujui

```
Status :

✓ Disetujui
```

User memperoleh notifikasi:

```
Selamat!

Anda berhasil menjadi peserta
Pelatihan Coding Dasar.
```

---

## Jika Ditolak

```
Status :

✕ Ditolak
```

User mendapat notifikasi:

```
Mohon maaf,
pendaftaran Anda belum dapat diterima.
```

---

# 9. Mengikuti Pelatihan

Pada hari pelaksanaan, user hadir sesuai jadwal.

Admin melakukan absensi peserta.

Status kehadiran:

```
Hadir
```

atau

```
Tidak Hadir
```

---

# 10. Sertifikat (Opsional)

Jika hadir, maka user memperoleh sertifikat.

```
Pelatihan Canva

Status :
✓ Lulus

Sertifikat :
Tersedia
```

Jika tidak hadir:

```
Status :

Tidak mendapatkan sertifikat
```

---

# 11. Riwayat

### **Riwayat Pendaftaran**
User dapat melihat daftar pelatihan yang pernah diikuti.

Contoh:

| Pelatihan       | Status              |
| --------------- | ------------------- |
| Coding Dasar    | Disetujui           |
| Microsoft Word  | Ditolak             |
| Microsoft Excel | Menunggu Verifikasi |

Status yang mungkin:

- Pending / Menunggu Verifikasi
- Disetujui
- Ditolak

Ini sesuai dengan proses admin melakukan verifikasi pendaftaran.

### **Riwayat Pelatihan**

Berisi pelatihan yang sudah diproses atau telah dilaksanakan.

| Pelatihan       | Status |
| --------------- | ------ |
| Coding Dasar    | Lulus  |
| Microsoft Word  | Lulus  |
| Microsoft Excel | Gagal  |

Status yang mungkin:
- Lulus
- Gagal

---


# 12. Logout

User keluar dari sistem.

```
Dashboard
      │
      ▼
Logout
      │
      ▼
Halaman Login
```

## Ringkasan fitur yang dimiliki User SIPPAD

1. Registrasi akun
    
2. Login
    
3. Melihat dashboard
    
4. Melihat daftar pelatihan
    
5. Melihat detail pelatihan
    
6. Mendaftar pelatihan
    
7. Melihat status pendaftaran (Pending/Disetujui/Ditolak)
    
8. Mengikuti pelatihan
    
9. Melihat status kehadiran
    
10. Mengunduh sertifikat (opsional)
    
11. Melihat riwayat pelatihan
    
12. Mengelola profil
    
13. Logout