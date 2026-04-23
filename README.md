# 🏟️ SportBook — Sistem Reservasi Lapangan Olahraga

**UJIAN CPMK-02 | Pemrograman Web II | Paket 5**

> Program Studi Informatika — Fakultas Teknik — Universitas Jenderal Soedirman

---

## 📋 Deskripsi Proyek

SportBook adalah aplikasi web full-stack untuk manajemen reservasi lapangan olahraga **GOR Satria Purwokerto**. Sistem ini menggantikan proses booking manual via telepon yang sering menyebabkan double-booking.

Aplikasi mendukung pemesanan lapangan **Futsal (2)**, **Badminton (4)**, dan **Basket (1)** dengan sistem slot per jam (08:00–22:00), harga dinamis peak/off-peak/weekend, dan kebijakan pembatalan dengan kalkulasi refund otomatis.

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Otorisasi
- Register, Login, Logout, Forgot Password (Laravel Breeze)
- 2 Role: **Admin** dan **User** dengan middleware proteksi route
- Redirect otomatis ke dashboard sesuai role setelah login

### 👨‍💼 Fitur Admin
- Dashboard: statistik, kalender booking, chart pendapatan harian
- CRUD Jenis Lapangan (Futsal, Badminton, Basket)
- CRUD Lapangan (nama, harga, foto, status aktif)
- Manajemen Booking: lihat semua, update status
- Laporan pendapatan per bulan dengan **Export PDF**

### 👤 Fitur User
- Katalog lapangan dengan filter jenis & search
- Slot picker interaktif per jam (grid 08:00–22:00)
- Multi-slot booking dengan validasi kontinu
- Upload bukti pembayaran
- Halaman "Booking Saya" dengan filter status
- Pembatalan booking dengan kalkulasi refund otomatis

### 🧠 Logika Bisnis Unik (Tantangan Paket 5)
| Fitur | Implementasi |
|-------|-------------|
| Deteksi konflik slot | `UNIQUE KEY (field_id, slot_date, slot_hour)` + `lockForUpdate()` |
| Harga Peak Hour (17–22) | `price_peak` = harga khusus per lapangan |
| Harga Weekend | `+20%` dari harga dasar (Sabtu & Minggu) |
| Multi-slot kontinu | Validasi di frontend (JS) + backend (PHP) |
| Refund otomatis | ≥24 jam = 100% · 12–24 jam = 50% · <12 jam = 0% |
| Race condition | DB transaction + `lockForUpdate()` |

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Framework | Laravel 13 (PHP 8.2+) |
| Database | MySQL 8.0+ |
| View Engine | Blade (tanpa Livewire/Inertia) |
| CSS Framework | Bootstrap 5.3 |
| Auth | Laravel Breeze |
| PDF Export | barryvdh/laravel-dompdf |
| Versioning | Git + GitHub (Private) |

---

## 🚀 Cara Instalasi & Menjalankan

### Requirements
- PHP >= 8.2 + Composer
- MySQL 8.0+ / MariaDB 10.6+
- Node.js & NPM

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/[username]/pemweb2-paket5-[NIM].git
cd pemweb2-paket5-[NIM]

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=sportbook
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Buat database MySQL bernama 'sportbook'
# Kemudian jalankan:
php artisan migrate --seed

# 6. Storage symlink
php artisan storage:link

# 7. Jalankan server
php artisan serve
```

Buka browser: http://localhost:8000

---

## 🔑 Kredensial Default

| Role  | Email | Password |
|-------|-------|----------|
| **Admin** | admin@sportbook.com | password |
| **User** | user@sportbook.com | password |

---

## 📁 Struktur Folder Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          ← Dashboard, FieldType, Field, Booking, Report
│   │   └── User/           ← Dashboard, FieldCatalog, Booking
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/                 ← User, FieldType, Field, Booking, BookingSlot
└── Services/
    └── BookingService.php  ← Logika bisnis utama (harga, konflik, refund)

database/
├── migrations/             ← 5 migration files
└── seeders/
    └── DatabaseSeeder.php  ← Admin + User + 3 FieldTypes + 7 Fields

resources/views/
├── layouts/app.blade.php   ← Main layout dengan sidebar
├── admin/                  ← Dashboard, CRUD, Booking, Report
├── user/                   ← Dashboard, Katalog, Booking
└── auth/                   ← Login, Register, Forgot Password
```

---

## 🎥 Demo Video

[Link YouTube — akan diisi setelah upload]

---

*Dibuat oleh: [Nama Mahasiswa] — NIM: [NIM] — Paket 5*
*Program Studi Informatika, Universitas Jenderal Soedirman*
