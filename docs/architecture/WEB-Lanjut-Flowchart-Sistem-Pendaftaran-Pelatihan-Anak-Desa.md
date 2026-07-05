# 1. System Flowchart Keseluruhan SIPPAD

```text
                    ┌─────────────┐
                    │    Mulai    │
                    └──────┬──────┘
                           │
                           ▼
                Apakah Sudah Memiliki Akun?
                           │
              ┌────────────┴────────────┐
              │                         │
             Tidak                     Ya
              │                         │
              ▼                         ▼
      Registrasi Akun             Login Sistem
              │                         │
              ▼                         ▼
      Simpan Data User         Validasi Username &
         ke Database              Password
                                      │
                        ┌─────────────┴─────────────┐
                        │                           │
                    Login Gagal               Login Berhasil
                        │                           │
                        ▼                           ▼
                  Kembali Login            Dashboard User
                                                │
                                                ▼
                                  Melihat Daftar Pelatihan
                                                │
                                                ▼
                                   Memilih Salah Satu
                                        Pelatihan
                                                │
                                                ▼
                                  Melihat Detail Pelatihan
                                                │
                                                ▼
                                   Klik Tombol Daftar
                                                │
                                                ▼
                                  Simpan Pendaftaran
                                      ke Database
                                                │
                                                ▼
                                   Status = Pending
                                                │
                                                ▼
                                   Admin Verifikasi
                                                │
                       ┌────────────────────────┴──────────────────────┐
                       │                                               │
                    Ditolak                                      Disetujui
                       │                                               │
                       ▼                                               ▼
              Notifikasi Ditolak                        Notifikasi Berhasil
                       │                                               │
                       ▼                                               ▼
                     Selesai                              Menunggu Hari Pelatihan
                                                                       │
                                                                       ▼
                                                             Mengikuti Pelatihan
                                                                       │
                                                                       ▼
                                                           Admin Input Kehadiran
                                                                       │
                                               ┌───────────────────────┴─────────────────────┐
                                               │                                             │
                                            Hadir                                      Tidak Hadir
                                               │                                             │
                                               ▼                                             ▼
                                    Generate Sertifikat                           Tidak Mendapat
                                          (Opsional)                                Sertifikat
                                               │
                                               ▼
                                   Riwayat Pelatihan User
                                               │
                                               ▼
                                            Logout
                                               │
                                               ▼
                                            Selesai
```

---

# 2. System Flowchart Admin

```text
                    ┌─────────────┐
                    │    Mulai    │
                    └──────┬──────┘
                           │
                           ▼
                     Login Admin
                           │
                           ▼
              Validasi Username & Password
                           │
               ┌───────────┴────────────┐
               │                        │
           Login Gagal          Login Berhasil
               │                        │
               ▼                        ▼
        Kembali Login          Dashboard Admin
                                        │
        ┌───────────────────────────────┼─────────────────────────────┐
        ▼                               ▼                             ▼
Kelola Pelatihan             Kelola Pendaftaran              Kelola Laporan
        │                               │                             │
        ▼                               ▼                             ▼
Tambah/Edit/Hapus             Lihat Data Pendaftar          Lihat Statistik
        │                               │
        ▼                               ▼
 Publish Pelatihan           Verifikasi Peserta
        │                               │
        │                   ┌───────────┴───────────┐
        │                   ▼                       ▼
        │              Disetujui               Ditolak
        │                   │                       │
        ▼                   ▼                       ▼
 Database Updated     Update Status User     Update Status User
        │
        ▼
Hari Pelaksanaan
        │
        ▼
Input Kehadiran
        │
        ▼
Upload Dokumentasi
        │
        ▼
Generate Sertifikat
        │
        ▼
Generate Laporan
        │
        ▼
Logout
        │
        ▼
Selesai
```

---

# 3. System Flowchart User

```text
                ┌────────────┐
                │   Mulai    │
                └─────┬──────┘
                      │
                      ▼
               Registrasi Akun
                      │
                      ▼
                Login Sistem
                      │
                      ▼
               Dashboard User
                      │
                      ▼
          Melihat Daftar Pelatihan
                      │
                      ▼
           Memilih Detail Pelatihan
                      │
                      ▼
             Apakah Akan Daftar?
                      │
          ┌───────────┴───────────┐
          │                       │
         Tidak                   Ya
          │                       │
          ▼                       ▼
Kembali Dashboard       Kirim Data Pendaftaran
                                  │
                                  ▼
                         Status Pending
                                  │
                                  ▼
                         Menunggu Verifikasi
                                  │
                    ┌─────────────┴─────────────┐
                    ▼                           ▼
                 Ditolak                  Disetujui
                    │                           │
                    ▼                           ▼
              Notifikasi               Mengikuti Pelatihan
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

# 4. System Flowchart Modul Pendaftaran

```text
Dashboard User
       │
       ▼
Lihat Pelatihan
       │
       ▼
Klik Detail
       │
       ▼
Klik Daftar
       │
       ▼
Konfirmasi Pendaftaran
       │
       ▼
Simpan ke Database
       │
       ▼
Status Pending
       │
       ▼
Admin Verifikasi
       │
 ┌─────┴───────┐
 ▼             ▼
Setuju      Tolak
 │             │
 ▼             ▼
Status      Status
Disetujui   Ditolak
 │
 ▼
Mengikuti Pelatihan
```

---

# 5. System Flowchart Modul Pelaksanaan

```text
Hari Pelaksanaan
        │
        ▼
Admin Membuka Absensi
        │
        ▼
Peserta Hadir?
        │
 ┌──────┴────────┐
 ▼               ▼
Ya             Tidak
 │               │
 ▼               ▼
Input Hadir  Input Tidak Hadir
 │
 ▼
Generate Sertifikat
 │
 ▼
Simpan Riwayat
 │
 ▼
Selesai
```

---

# Rekomendasi untuk Dokumentasi Skripsi atau Proyek

Agar dokumentasi SIPPAD tersusun rapi dan mudah dipahami, **System Flowchart** sebaiknya dibagi menjadi lima bagian:

1. **System Flowchart Utama**, menggambarkan alur sistem secara end-to-end mulai dari registrasi hingga selesai mengikuti pelatihan.
    
2. **System Flowchart Admin**, menggambarkan seluruh aktivitas administrator dalam mengelola pelatihan dan peserta.
    
3. **System Flowchart User**, menggambarkan perjalanan peserta mulai dari registrasi hingga melihat riwayat pelatihan.
    
4. **System Flowchart Pendaftaran**, yang berfokus pada proses pendaftaran dan verifikasi peserta.
    
5. **System Flowchart Pelaksanaan Pelatihan**, yang menjelaskan proses absensi, kehadiran, dan penerbitan sertifikat.