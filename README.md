# 🎓 SPK Pemilihan Jurusan Kuliah — Metode SAW

Sistem Pendukung Keputusan (SPK) berbasis web untuk membantu pemilihan jurusan kuliah menggunakan metode **Simple Additive Weighting (SAW)**. Sistem ini memungkinkan pengguna mengelola data alternatif, kriteria, bobot, serta menghitung dan menampilkan rekomendasi jurusan secara otomatis berdasarkan nilai preferensi tertinggi.

---

## ✨ Fitur Utama

- 🔐 **Autentikasi** — Login admin dengan proteksi session
- 📋 **Manajemen Alternatif** — CRUD data jurusan kuliah
- ⚖️ **Manajemen Kriteria & Bobot** — Atur kriteria dengan tipe *benefit* atau *cost*
- 📊 **Matriks Keputusan (X)** — Tampilkan dan isi nilai evaluasi setiap jurusan
- 🔢 **Normalisasi Matriks (R)** — Dihitung otomatis sesuai tipe atribut
- 🏆 **Nilai Preferensi & Perangkingan** — Hasil akhir ranking jurusan terbaik
- 📐 **Tampilan Formula Matematika** — Menggunakan KaTeX untuk render rumus SAW

---

## 🛠️ Tech Stack

| Komponen | Detail |
|---|---|
| Backend | PHP (Native) |
| Database | MySQL (MariaDB) |
| Frontend | HTML, Bootstrap 5.3 |
| Math Render | KaTeX |
| Template UI | Mazer Admin Dashboard |
| Server | XAMPP (localhost) |

---

## ⚙️ Cara Instalasi & Setup

### Prasyarat
- [XAMPP](https://www.apachefriends.org/) (PHP 8.x + MySQL/MariaDB)
- Browser modern (Chrome, Firefox, Edge)

### Langkah-langkah

**1. Clone repository ini**
```bash
git clone https://github.com/Ryper29/SPKSAW.git
```

**2. Pindahkan folder ke direktori XAMPP**
```
Salin folder SPKSAW ke: C:\xampp\htdocs\spksaw
```

**3. Import database**
- Buka **phpMyAdmin** di browser: `http://localhost/phpmyadmin`
- Buat database baru dengan nama: `db_saw`
- Pilih database `db_saw` → klik tab **Import**
- Upload file `db/db_saw.sql` → klik **Go**

**4. (Opsional) Sesuaikan konfigurasi koneksi**

Edit file `include/conn.php` jika konfigurasi MySQL kamu berbeda:
```php
$dbhost = 'localhost';
$dbuser = 'root';   // sesuaikan username MySQL
$dbpass = '';       // sesuaikan password MySQL
$dbname = 'db_saw';
```

**5. Jalankan aplikasi**
- Pastikan Apache & MySQL di XAMPP sudah **Start**
- Buka browser, akses: `http://localhost/spksaw`

---

## 🔑 Akun Default

| Username | Password |
|---|---|
| `admin` | `admin` |

---

## 📁 Struktur Direktori

```
spksaw/
├── assets/                 # CSS, JS, icon, dan vendor library
├── db/
│   └── db_saw.sql          # Script SQL database
├── include/
│   └── conn.php            # Konfigurasi koneksi database
├── layout/
│   ├── head.php            # HTML head & CSS
│   ├── sidebar.php         # Navigasi sidebar
│   ├── footer.php          # Footer
│   └── js.php              # Script JS
├── R.php                   # Helper: hitung matriks ternormalisasi (R)
├── W.php                   # Helper: ambil array bobot kriteria (W)
├── index.php               # Dashboard
├── alternatif.php          # Manajemen jurusan (alternatif)
├── bobot.php               # Manajemen kriteria & bobot
├── matrik.php              # Matriks keputusan & normalisasi
├── preferensi.php          # Nilai preferensi & perangkingan
├── login.php               # Halaman login
└── logout.php              # Proses logout
```

---

## 📐 Alur Perhitungan SAW

```
1. Tentukan Alternatif (Jurusan) → A₁, A₂, ..., Aₙ
2. Tentukan Kriteria + Bobot     → C₁(w₁), C₂(w₂), ..., Cₘ(wₘ)
3. Buat Matriks Keputusan (X)   → Nilai setiap alternatif per kriteria
4. Normalisasi Matriks (R)
   - Benefit : Rᵢⱼ = Xᵢⱼ / max(Xᵢⱼ)
   - Cost    : Rᵢⱼ = min(Xᵢⱼ) / Xᵢⱼ
5. Hitung Nilai Preferensi (P)  → Pᵢ = Σ(wⱼ × Rᵢⱼ)
6. Ranking → Alternatif dengan P tertinggi = rekomendasi terbaik
```

---

## 👤 Author

**Ryper29**
- GitHub: [@Ryper29](https://github.com/Ryper29)

---

## 📄 Lisensi

Project ini dibuat untuk keperluan akademik. Bebas digunakan dan dimodifikasi untuk pembelajaran.
