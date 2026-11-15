# STOCKIFY
### Sistem Informasi Manajemen Inventaris Barang

## Deskripsi

STOCKIFY merupakan aplikasi berbasis web yang dirancang untuk membantu proses pengelolaan inventaris barang. Aplikasi ini menyediakan fasilitas untuk mengelola data produk, kategori, supplier, memantau persediaan, mencatat transaksi barang masuk dan keluar, serta menyajikan laporan inventaris.

Sistem ini dikembangkan menggunakan PHP Native dengan menerapkan konsep arsitektur Model-View-Controller (MVC) dan MySQL sebagai sistem manajemen basis data.

## Identitas Pengembang

| Keterangan | Informasi |
|---|---|
| Nama | Clara Sembiring |
| Institusi | Universitas Minar Indonesia |
| Kelas | KA-Pagi |
| Nama Proyek | STOCKIFY |
| Jenis Aplikasi | Web-Based Inventory Management System |

## Fitur Aplikasi

### 1. Dashboard
Menampilkan ringkasan informasi inventaris, jumlah produk, kondisi persediaan, dan informasi stok minimum.

### 2. Manajemen Produk
- Menambahkan data produk.
- Menampilkan daftar produk.
- Mengubah informasi produk.
- Menghapus produk.
- Melakukan pencarian produk.

### 3. Manajemen Kategori
- Menambahkan kategori produk.
- Mengubah data kategori.
- Menghapus kategori.
- Menampilkan daftar kategori.

### 4. Manajemen Supplier
- Menambahkan data supplier.
- Mengubah informasi supplier.
- Menghapus data supplier.
- Menampilkan daftar supplier.

### 5. Manajemen Stok
- Mencatat transaksi barang masuk (Stock In).
- Mencatat transaksi barang keluar (Stock Out).
- Memperbarui jumlah persediaan berdasarkan transaksi.
- Menampilkan riwayat pergerakan stok.

### 6. Laporan Inventaris
- Pencarian berdasarkan nama produk dan SKU.
- Filter berdasarkan jenis transaksi.
- Filter berdasarkan rentang tanggal.
- Ekspor laporan ke format CSV.
- Ekspor laporan ke format PDF.

### 7. Autentikasi Pengguna
- Login dan logout.
- Verifikasi password.
- Proteksi halaman menggunakan session.

## Teknologi

| Teknologi | Keterangan |
|---|---|
| PHP Native | Bahasa pemrograman backend |
| MySQL | Sistem manajemen database |
| PDO | Penghubung aplikasi dengan database |
| HTML | Struktur halaman web |
| CSS | Pengaturan tampilan antarmuka |
| JavaScript | Interaksi pada halaman |
| Composer | Manajemen dependensi PHP |
| Dompdf | Pembuatan dokumen PDF |
| XAMPP | Lingkungan server lokal |

## Struktur Direktori

```text
STOCKIFY/
│
├── app/
│   ├── controllers/
│   ├── core/
│   ├── models/
│   └── views/
│
├── config/
│
├── database/
│   ├── schema.sql
│   └── stockify_db.sql
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── index.php
│
├── storage/
│
├── composer.json
├── composer.lock
├── .gitignore
└── README.md
```

## Instalasi

### Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan perangkat telah memiliki:

- PHP 8.0 atau versi yang kompatibel dengan dependensi proyek.
- MySQL atau MariaDB.
- Apache Web Server.
- Composer.
- XAMPP atau lingkungan server lokal sejenis.

### 1. Mengunduh Source Code

Unduh repository STOCKIFY dari GitHub, kemudian letakkan folder proyek di direktori:

```text
C:\xampp\htdocs\stockify
```

### 2. Menjalankan Server

Buka XAMPP Control Panel, kemudian aktifkan Apache dan MySQL.

### 3. Membuat Database

Buka phpMyAdmin melalui:

```text
http://localhost/phpmyadmin
```

Import file database berikut:

```text
database/stockify_db.sql
```

Database yang digunakan bernama:

```text
stockify_db
```

File `schema.sql` juga disediakan sebagai referensi struktur tabel dan data awal aplikasi.

### 4. Konfigurasi Database

Buka file:

```text
app/core/Database.php
```

Sesuaikan konfigurasi koneksi database dengan lingkungan server yang digunakan.

Konfigurasi default XAMPP:

```php
private $host = 'localhost';
private $dbname = 'stockify_db';
private $username = 'root';
private $password = '';
```

### 5. Instalasi Dependensi

Buka terminal pada direktori utama proyek, kemudian jalankan:

```bash
composer install
```

Perintah tersebut akan menginstal seluruh dependensi yang tercatat pada `composer.lock`, termasuk Dompdf.

### 6. Menjalankan Aplikasi

Buka browser dan akses alamat berikut:

```text
http://localhost/stockify/public/index.php
```

Gunakan akun yang telah disediakan untuk masuk ke dalam aplikasi.

## Struktur Database

STOCKIFY menggunakan lima tabel utama:

| Nama Tabel | Fungsi |
|---|---|
| users | Menyimpan informasi pengguna aplikasi |
| categories | Menyimpan kategori produk |
| suppliers | Menyimpan data pemasok |
| products | Menyimpan informasi produk dan persediaan |
| stock_movements | Mencatat transaksi pergerakan stok |

Relasi antar tabel menggunakan Primary Key dan Foreign Key untuk menjaga keterkaitan serta integritas data.

## Informasi Proyek

STOCKIFY dikembangkan sebagai proyek aplikasi berbasis web dengan fokus pada pengelolaan inventaris barang. Sistem ini mengintegrasikan pengelolaan data, pencatatan transaksi persediaan, dan penyusunan laporan dalam satu aplikasi.

Proyek ini ditujukan untuk keperluan pembelajaran dan demonstrasi penerapan pemrograman web menggunakan PHP Native, MySQL, dan arsitektur MVC.

---

**STOCKIFY — Inventory Management System**

Universitas Minar Indonesia  
Kelas KA-Pagi  
Pengembang: Clara Sembiring