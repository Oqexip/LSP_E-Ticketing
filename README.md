# ✈️ E-Ticketing Easy
> **Solusi Manajemen Tiket Pesawat Sederhana & Efisien**

Aplikasi ini dibangun khusus untuk kebutuhan **LSP RPL (Rekayasa Perangkat Lunak)**. Fokus utama proyek ini adalah kemudahan penggunaan (*user-friendly*) dan implementasi logika *backend* yang solid menggunakan Laravel 11.

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

---

## 📌 Fitur Utama

### 👤 Pengguna (User)
- [x] **Authentication:** Registrasi dan Login akun.
- [x] **Smart Dashboard:** Menampilkan jadwal penerbangan yang masih memiliki stok.
- [x] **Direct Booking:** Pilih jumlah kursi dengan kalkulasi harga otomatis (Real-time JS).
- [x] **Order History:** Pantau semua riwayat perjalanan yang telah dipesan.

### 🔑 Administrator
- [x] **Schedule Management:** Full CRUD (Create, Read, Update, Delete) jadwal pesawat.
- [x] **Transaction Monitoring:** Melihat data pemesanan dari seluruh user secara terpusat.
- [x] **Automatic Stock Control:** Stok berkurang otomatis setiap kali transaksi berhasil.

---

## 📂 Struktur Database

| Tabel | Deskripsi | Field Kunci |
| :--- | :--- | :--- |
| **Users** | Akun pengguna & level akses | `id`, `name`, `email`, `role` |
| **Schedules** | Data jadwal penerbangan | `plane_name`, `origin`, `destination`, `stock` |
| **Bookings** | Riwayat transaksi | `user_id`, `schedule_id`, `total_price` |

---

## ⚙️ Cara Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan project di lokal:

1. **Clone Project**
   ```bash
   git clone [https://github.com/username/e-ticketing-easy.git](https://github.com/username/e-ticketing-easy.git)
   cd e-ticketing-easy
Dependencies & Environment

Bash
composer install
cp .env.example .env
php artisan key:generate
Database Setup

Buat database baru di phpMyAdmin.

Update konfigurasi database di file .env.

Jalankan migrasi:

Bash
php artisan migrate
Launch!

Bash
php artisan serve
Buka: http://localhost:8000

📁 Struktur Folder Penting
Agar mudah dalam pengembangan, berikut adalah letak file-file utamanya:

Plaintext
app/
 └── Http/Controllers/
      ├── AuthController.php        # Logika Login/Register
      ├── BookingController.php     # Logika Pemesanan User
      └── Admin/
           ├── ScheduleController.php # CRUD Jadwal Admin
           └── BookingController.php  # Monitoring Admin
resources/views/
 ├── auth/      # Tampilan Login/Register
 ├── user/      # Dashboard & History User
 └── admin/     # Panel Kendali Admin