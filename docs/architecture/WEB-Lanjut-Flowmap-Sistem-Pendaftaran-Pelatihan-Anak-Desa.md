# Flowmap Sistem Pendaftaran Pelatihan Anak Desa (SIPPAD)

## Flowmap Keseluruhan Sistem

```text
                    +------------------+
                    |      User        |
                    +--------+---------+
                             │
                             │ Registrasi
                             ▼
                   +---------------------+
                   |  Data Registrasi    |
                   +----------+----------+
                              │
                              ▼
                        +------------+
                        |  Database  |
                        +------------+
                              ▲
                              │
                              │ Login
                              │
                    +---------+----------+
                    |   Validasi Akun    |
                    +---------+----------+
                              │
                              ▼
                    +--------------------+
                    | Dashboard Peserta  |
                    +---------+----------+
                              │
                              │
                              ▼
                  Melihat Daftar Pelatihan
                              │
                              ▼
                    Detail Pelatihan
                              │
                              ▼
                    Mendaftar Pelatihan
                              │
                              ▼
                        Database
                              │
                              ▼
                    +------------------+
                    |      Admin       |
                    +--------+---------+
                             │
                             ▼
                  Verifikasi Pendaftaran
                             │
                  ┌──────────┴──────────┐
                  ▼                     ▼
             Disetujui              Ditolak
                  │                     │
                  ▼                     ▼
             Database             Database
                  │
                  ▼
          Status Pendaftaran User
                  │
                  ▼
         Mengikuti Pelatihan
                  │
                  ▼
          Admin Input Kehadiran
                  │
                  ▼
              Database
                  │
                  ▼
       Generate Sertifikat (Opsional)
                  │
                  ▼
          Riwayat Pelatihan User
```

---

# Flowmap Admin

```text
Login Admin
      │
      ▼
Dashboard Admin
      │
      ├─────────────► Kelola Pelatihan
      │                     │
      │                     ▼
      │             Tambah/Edit/Hapus
      │                     │
      │                     ▼
      │                 Database
      │
      ├─────────────► Publish Pelatihan
      │                     │
      │                     ▼
      │                 Database
      │
      ├─────────────► Verifikasi Peserta
      │                     │
      │              Setuju / Tolak
      │                     │
      │                     ▼
      │                 Database
      │
      ├─────────────► Input Kehadiran
      │                     │
      │                     ▼
      │                 Database
      │
      ├─────────────► Upload Dokumentasi
      │                     │
      │                     ▼
      │                 Database
      │
      └─────────────► Laporan
                            │
                            ▼
                    PDF / Excel / CSV
```

---

# Flowmap User

```text
Registrasi
      │
      ▼
Database
      │
      ▼
Login
      │
      ▼
Dashboard
      │
      ▼
Lihat Pelatihan
      │
      ▼
Detail Pelatihan
      │
      ▼
Daftar Pelatihan
      │
      ▼
Database
      │
      ▼
Status Pending
      │
      ▼
Admin Verifikasi
      │
 ┌────┴─────┐
 ▼          ▼
Setuju    Tolak
 │          │
 ▼          ▼
Notifikasi Notifikasi
 │
 ▼
Mengikuti Pelatihan
 │
 ▼
Absensi
 │
 ▼
Sertifikat
 │
 ▼
Riwayat Pelatihan
```

---

# Flowmap Level 0 (Context Diagram)

```text
                   +--------------------+
                   |      ADMIN         |
                   +---------+----------+
                             │
         Kelola Pelatihan, Verifikasi,
      Kehadiran, Dokumentasi, Laporan
                             │
                             ▼

                +---------------------------+
                |         SIPPAD            |
                | Sistem Pendaftaran        |
                | Pelatihan Anak Desa       |
                +-------------+-------------+

                             ▲
                             │
 Registrasi, Login, Pendaftaran,
 Melihat Pelatihan, Riwayat,
 Sertifikat
                             │

                  +----------+-----------+
                  |        USER          |
                  +----------------------+
```

---

# Flowmap Level 1

```text
                 USER
                   │
        Registrasi / Login
                   │
                   ▼
            Authentication
                   │
                   ▼
            Dashboard User
                   │
         ┌─────────┴──────────┐
         ▼                    ▼
 Lihat Pelatihan      Riwayat Pelatihan
         │
         ▼
 Detail Pelatihan
         │
         ▼
 Daftar Pelatihan
         │
         ▼
      DATABASE
         ▲
         │
  Verifikasi Admin
         │
         ▼
      Dashboard Admin
         │
 ┌───────┼─────────────┐
 ▼       ▼             ▼
CRUD   Kehadiran    Laporan
Pelatihan
```

---

# Flowmap Proses Bisnis SIPPAD

```text
Admin Membuat Pelatihan
            │
            ▼
     Pelatihan Dipublish
            │
            ▼
     User Melihat Pelatihan
            │
            ▼
    User Mendaftar Pelatihan
            │
            ▼
       Data Tersimpan
            │
            ▼
     Admin Verifikasi Data
            │
     ┌──────┴───────┐
     ▼              ▼
 Disetujui      Ditolak
     │              │
     ▼              ▼
Notifikasi     Notifikasi
     │
     ▼
Mengikuti Pelatihan
     │
     ▼
Admin Input Kehadiran
     │
     ▼
Generate Sertifikat
     │
     ▼
Riwayat Pelatihan
     │
     ▼
Laporan Admin
```