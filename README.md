# SPK Kelayakan Influencer - Metode WASPAS

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

Sistem Pendukung Keputusan (SPK) berbasis web untuk menentukan kelayakan influencer dalam kegiatan *endorsement* menggunakan metode **Weighted Aggregated Sum Product Assessment (WASPAS)**.

## 🛠️ Tech Stack

Komponen dan teknologi yang digunakan dalam proyek ini:

| Komponen | Teknologi | Deskripsi |
| :--- | :--- | :--- |
| **Framework** | ![Laravel](https://img.shields.io/badge/-Laravel_12-FF2D20?logo=laravel&logoColor=white) | Framework PHP utama untuk backend & routing. |
| **Bahasa** | ![PHP](https://img.shields.io/badge/-PHP_8.x-777BB4?logo=php&logoColor=white) | Bahasa pemrograman server-side. |
| **Database** | ![MySQL](https://img.shields.io/badge/-MySQL-4479A1?logo=mysql&logoColor=white) | Penyimpanan data relasional. |
| **Frontend** | ![Bootstrap](https://img.shields.io/badge/-Bootstrap_5-7952B3?logo=bootstrap&logoColor=white) | Framework CSS untuk tampilan responsif. |
| **Templating** | ![Blade](https://img.shields.io/badge/-Blade-FF2D20?logo=laravel&logoColor=white) | Engine templating bawaan Laravel. |

## 📂 Struktur Folder

Berikut adalah struktur folder utama dalam proyek ini:

```
d:\Spk-web
├── app
│   ├── Http
│   │   ├── Controllers  # Logika aplikasi (AuthController, Staff, Manager)
│   │   └── Middleware   # Filter request (Role check)
│   └── Models           # Representasi data (User, Influencer, Criterion)
├── database
│   ├── migrations       # Skema database
│   └── seeders          # Data awal (User seeder)
├── resources
│   └── views            # Tampilan antarmuka (Blade templates)
│       ├── auth         # Login page
│       ├── layouts      # Master layout
│       ├── manager      # Dashboard & fitur Manager
│       └── staff        # Dashboard & fitur Staff
├── routes
│   └── web.php          # Definisi routing aplikasi
└── public               # Aset publik (CSS, JS, Images)
```

## ✨ Fitur Utama

### 🔐 Autentikasi
- **Login**: Akses aman untuk pengguna.
- **Multi-Role**: Pemisahan hak akses antara **Manager** dan **Staff**.

### 👨‍💼 Manager
- **Dashboard**: Ringkasan statistik sistem.
- **Manajemen Staff**: Mengelola akun pengguna staff.
- **Monitoring WASPAS**: Melihat hasil perhitungan yang dilakukan staff.
- **Riwayat Endorse**: Melihat daftar influencer yang telah dipilih/di-endorse.

### 🧑‍💻 Staff
- **Dashboard**: Statistik personal staff.
- **Manajemen Influencer**: CRUD data influencer.
- **Kriteria & Bobot**: Mengatur kriteria penilaian dan bobotnya.
- **Perhitungan WASPAS**: Melakukan proses perhitungan SPK.
- **Seleksi Influencer**: Menandai influencer yang layak untuk di-endorse.

## 🧮 Metode WASPAS

Metode **WASPAS (Weighted Aggregated Sum Product Assessment)** menggabungkan dua metode:
1. **Weighted Sum Model (WSM)**
2. **Weighted Product Model (WPM)**

Rumus perhitungan:
\[ Q_i = \lambda \cdot Q_i^{(WSM)} + (1 - \lambda) \cdot Q_i^{(WPM)} \]

Dimana nilai \(\lambda\) (lambda) biasanya diset **0.5** untuk keseimbangan.

## 🚀 Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di lokal:

1. **Clone Repository**
   ```bash
   git clone https://github.com/rizkipr05/spk-waspas.git
   cd spk-waspas
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.
   ```bash
   cp .env.example .env
   ```

4. **Generate Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi & Seeding Database**
   Pastikan database MySQL sudah dibuat, lalu jalankan:
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://localhost:8000`.

## � Dokumentasi API (Postman)

Proyek ini menyertakan koleksi Postman untuk pengujian API. File koleksi bernama `api(postman).json` terletak di root direktori proyek.

**Cara Menggunakan:**

1. Buka aplikasi **Postman**.
2. Klik tombol **Import** di pojok kiri atas.
3. Drag & drop file `api(postman).json` atau pilih file tersebut dari direktori proyek.
4. Koleksi akan muncul di sidebar Postman.
5. Anda dapat langsung menjalankan request yang tersedia (pastikan server lokal berjalan).

### 📡 Detail Endpoint API

Berikut adalah daftar endpoint yang tersedia dalam API ini:

#### 🔐 Auth
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `POST` | `/api/login` | Login user & dapatkan token |
| `GET` | `/api/me` | Mendapatkan info user yang sedang login |
| `POST` | `/api/logout` | Logout & invalidasi token |

#### 🧑‍💻 Staff
**Dashboard**
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/staff/dashboard` | Statistik dashboard staff |

**Influencers**
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/staff/influencers` | List semua influencer |
| `POST` | `/api/staff/influencers` | Tambah influencer baru |
| `GET` | `/api/staff/influencers/{id}` | Detail influencer |
| `PUT` | `/api/staff/influencers/{id}` | Update data influencer |
| `DELETE` | `/api/staff/influencers/{id}` | Hapus influencer |

**Criteria (Kriteria)**
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/staff/criteria` | List kriteria |
| `POST` | `/api/staff/criteria` | Tambah kriteria baru |
| `PUT` | `/api/staff/criteria/{id}` | Update kriteria |
| `DELETE` | `/api/staff/criteria/{id}` | Hapus kriteria |

**WASPAS**
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/staff/waspas` | List riwayat perhitungan |
| `GET` | `/api/staff/waspas/{id}` | Detail hasil perhitungan |
| `POST` | `/api/staff/waspas/item/{id}/toggle` | Pilih/Batal pilih influencer (Endorse) |

#### 👨‍💼 Manager
**Dashboard**
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/manager/dashboard` | Statistik dashboard manager |

**Staff Management**
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/manager/staff` | List akun staff |
| `POST` | `/api/manager/staff` | Tambah akun staff |
| `PUT` | `/api/manager/staff/{id}` | Update akun staff |
| `DELETE` | `/api/manager/staff/{id}` | Hapus akun staff |

**Monitoring**
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/manager/waspas` | Lihat semua hasil perhitungan staff |
| `GET` | `/api/manager/endorse-history` | Lihat daftar influencer yang terpilih |

### 📂 Struktur File API

Lokasi file penting terkait implementasi API:

```
d:\Spk-web
├── routes
│   └── api.php                  # Definisi Route API
├── app
│   └── Http
│       └── Controllers
│           └── Api              # Controller Logic API
│               ├── AuthController.php
│               ├── Staff
│               │   ├── DashboardController.php
│               │   ├── InfluencerController.php
│               │   └── ...
│               └── Manager
│                   ├── DashboardController.php
│                   ├── StaffController.php
│                   └── ...
```

## �📄 Lisensi

Proyek ini dibuat untuk keperluan akademik dan pembelajaran.
