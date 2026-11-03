# PANDUAN IMPORT DATABASE LENTERA QUR'AN DI PHPMYADMIN

Panduan ini dibuat khusus sesuai tampilan phpMyAdmin lokal Anda (`localhost/phpmyadmin`).

---

## 📁 File yang Tersedia di Folder Ini:
1. **`lentera_quran.sql` (SANGAT DIREKOMENDASIKAN)**
   - Berisi **Struktur Lengkap + Seluruh Data Master**:
     - 114 Surah Al-Qur'an
     - 6.236 Ayat Al-Qur'an (Arab, Latin, Terjemahan, Audio URL)
     - 10 Bacaan Tahlil lengkap
     - 4 Kategori Doa & 13 Doa
     - Akun Super Admin & Pengaturan User bawaan
   - Sudah dilengkapi perintah otomatis `CREATE DATABASE IF NOT EXISTS lentera_quran; USE lentera_quran;`.

2. **`lentera_quran_struktur_saja.sql`**
   - Hanya berisi struktur tabel (DDL murni tanpa data) untuk keperluan database kosong (~36 KB).

---

## 🚀 Langkah-Langkah Import (2 Menit Selesai):

### Cara 1: Langsung dari Menu Beranda phpMyAdmin (Paling Cepat)
Karena file `.sql` sudah kami lengkapi dengan perintah pembuat database otomatis:
1. Buka browser di halaman phpMyAdmin Anda: `http://localhost/phpmyadmin/`
2. Di baris menu atas, klik tab **Import** (sebelah kanan tab *Export*).
3. Pada bagian **File to import**, klik tombol **Choose File** (Pilih File).
4. Pilih file:
   `c:\Users\Haikal\OneDrive\Dokumen\KULIAH\SMTR 7\MAGANG\Lentera Qur'an\database_siap_import\lentera_quran.sql`
5. Gulir ke bagian paling bawah, lalu klik tombol **Import** (atau tombol **Go / Kirim**).
6. Tunggu beberapa detik hingga muncul notifikasi hijau bertuliskan:
   *"Import has been successfully finished, xxx queries executed."*

---

### Cara 2: Import ke Database yang Sudah Ada
Jika Anda ingin me-refresh database `lentera_quran` yang sudah ada di menu kiri:
1. Di sidebar sebelah kiri, klik database **`lentera_quran`**.
2. Klik tab **Import** di bagian atas.
3. Klik tombol **Choose File** (Pilih File) dan pilih `lentera_quran.sql`.
4. Klik **Import / Go** di bagian bawah.

---

## 🔑 Akun Default Setelah Import:
Setelah database berhasil di-import, Anda bisa langsung login ke aplikasi menggunakan akun bawaan:

* **Role:** Super Admin
* **Email:** `superadmin@lenteraquran.com`
* **Kata Sandi:** `password123`

---

## 👤 Pembuatan Akun Baru (Register):
Setelah database di-import:
* Buka aplikasi Lentera Qur'an di browser: `http://localhost:8000/register` (atau URL lokal Anda).
* Masukkan Nama, Email, dan Password baru.
* Klik **Daftar / Register**.
* Akun baru Anda akan **langsung tersimpan di database MySQL** pada tabel `users` dan pengaturan tampilannya pada tabel `user_settings`.
