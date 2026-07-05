# ERD Sistem Pendaftaran Pelatihan Anak Desa berbasis Web Laravel

# 1. Daftar Entitas dan Atribut

| Nama Entitas              | Deskripsi                         | Atribut                                                                                                       |
| ------------------------- | --------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| **User**                  | Menyimpan data peserta pelatihan  | **id_user**, nama, email, password, no_hp, alamat                                                             |
| **Admin**                 | Menyimpan data administrator      | **id_admin**, nama_admin, username, password                                                                  |
| **Kategori_Pelatihan**    | Kategori pelatihan                | **id_kategori**, nama_kategori, deskripsi                                                                     |
| **Pelatihan**             | Data master pelatihan             | **id_pelatihan**, id_kategori, judul, deskripsi, narasumber, lokasi, tanggal, jam, kuota, persyaratan, status |
| **Pendaftaran**           | Menyimpan data pendaftaran user   | **id_pendaftaran**, id_user, id_pelatihan, tanggal_daftar, status                                             |
| **Kehadiran**             | Menyimpan absensi peserta         | **id_kehadiran**, id_pendaftaran, status_kehadiran                                                            |
| **Sertifikat** (Opsional) | Menyimpan data sertifikat peserta | **id_sertifikat**, id_kehadiran, nomor_sertifikat, tanggal_terbit                                             |
| **Dokumentasi**           | Dokumentasi kegiatan pelatihan    | **id_dokumentasi**, id_pelatihan, foto_kegiatan                                                               |

---

# 2. Penjelasan Masing-masing Entitas

## A. User

Menyimpan seluruh data peserta.

```
User
---------------------
id_user (PK)
nama
email
password
no_hp
alamat
```

---

## B. Admin

Digunakan untuk login administrator.

```
Admin
---------------------
id_admin (PK)
nama_admin
username
password
```

---

## C. Kategori Pelatihan

Contoh:

- Teknologi
    
- Kewirausahaan
    
- Pertanian
    
- UMKM
    
- Desain
    

```
Kategori
---------------------
id_kategori (PK)
nama_kategori
deskripsi
```

---

## D. Pelatihan

Master data pelatihan.

```
Pelatihan
---------------------
id_pelatihan (PK)
id_kategori (FK)
judul
deskripsi
narasumber
lokasi
tanggal
jam
kuota
persyaratan
status
```

Status:

- Draft
    
- Publish
    
- Closed
    
- Selesai
    

---

## E. Pendaftaran

Mencatat siapa mendaftar ke pelatihan apa.

```
Pendaftaran
---------------------
id_pendaftaran (PK)
id_user (FK)
id_pelatihan (FK)
tanggal_daftar
status
```

Status:

- Pending
    
- Disetujui
    
- Ditolak
    

---

## F. Kehadiran

Digunakan saat hari pelaksanaan.

```
Kehadiran
---------------------
id_kehadiran (PK)
id_pendaftaran (FK)
status_kehadiran
```

Status:

- Hadir
    
- Tidak Hadir
    

---

## G. Sertifikat (Opsional)

```
Sertifikat
---------------------
id_sertifikat (PK)
id_kehadiran (FK)
nomor_sertifikat
tanggal_terbit
```

---

## H. Dokumentasi

```
Dokumentasi
---------------------
id_dokumentasi (PK)
id_pelatihan (FK)
foto_kegiatan
```

---

# 3. Relasi Antar Entitas

## User → Pendaftaran (1 : M)

Satu user dapat mendaftar banyak pelatihan.

```
User
  │
  │ 1
  │
  └──────────────< M
                  │
            Pendaftaran
```

Foreign Key:

```
id_user
```

---

## Pelatihan → Pendaftaran (1 : M)

Satu pelatihan memiliki banyak peserta.

```
Pelatihan
    │
    │1
    │
    └─────────────< M
                   │
             Pendaftaran
```

Foreign Key:

```
id_pelatihan
```

---

## Kategori → Pelatihan (1 : M)

```
Kategori
    │
    │1
    │
    └──────────< M
                │
           Pelatihan
```

Foreign Key:

```
id_kategori
```

---

## Pendaftaran → Kehadiran (1 : 1)

Satu pendaftaran menghasilkan satu data absensi.

```
Pendaftaran
      │
      │1
      │
      └──────────1
                 │
            Kehadiran
```

---

## Kehadiran → Sertifikat (1 : 1)

Jika hadir maka memiliki sertifikat.

```
Kehadiran
      │
      │1
      │
      └──────────1
                 │
             Sertifikat
```

---

## Pelatihan → Dokumentasi (1 : M)

Satu pelatihan dapat memiliki banyak foto dokumentasi.

```
Pelatihan
     │
     │1
     │
     └─────────< M
                │
          Dokumentasi
```

---

# 4. ERD Konseptual SIPPAD

```text
                     KATEGORI
                  ----------------
                  id_kategori (PK)
                  nama_kategori
                  deskripsi
                        │
                        │1
                        │
                        ▼
                   PELATIHAN
        -------------------------------
        id_pelatihan (PK)
        id_kategori (FK)
        judul
        deskripsi
        narasumber
        lokasi
        tanggal
        jam
        kuota
        persyaratan
        status
            │
            │1
            │
      ┌─────┴───────────────┐
      ▼                     ▼
PENDAFTARAN           DOKUMENTASI
----------------      ----------------
id_pendaftaran(PK)    id_dokumentasi(PK)
id_user (FK)          id_pelatihan(FK)
id_pelatihan(FK)      foto_kegiatan
tanggal_daftar
status
      │
      │M
      │
      ▼
    USER
-------------------
id_user (PK)
nama
email
password
no_hp
alamat

PENDAFTARAN
      │
      │1
      ▼
KEHADIRAN
-------------------
id_kehadiran (PK)
id_pendaftaran(FK)
status_kehadiran
      │
      │1
      ▼
SERTIFIKAT
-------------------
id_sertifikat (PK)
id_kehadiran(FK)
nomor_sertifikat
tanggal_terbit

ADMIN
-------------------
id_admin (PK)
nama_admin
username
password
```