# Dokumentasi Struktur Folder & Panduan PortalNilai-SMP3

Website Portal Nilai Siswa resmi **SMP Negeri 3 Unggulan** dibangun menggunakan arsitektur Laravel yang terorganisir rapi dan modular.

---

## 📁 Struktur Penataan File & Folder

Struktur folder dipisahkan berdasarkan tanggung jawabnya (*Separation of Concerns*) agar tidak menumpuk di satu tempat:

```
portalnilai-smp3/
│
├── app/
│   ├── Http/
│   │   └── Controllers/               <-- Logika alur setiap halaman
│   │       ├── HomeController.php     (Halaman Beranda & ringkasan portal)
│   │       ├── TentangController.php  (Halaman Profil & Visi Misi sekolah)
│   │       ├── NilaiController.php    (Halaman Cek Nilai & Cetak Transkrip)
│   │       ├── JadwalController.php   (Halaman Jadwal Ujian PAS & CBT)
│   │       ├── GuruController.php     (Halaman Dewan Guru & Tenaga Pendidik)
│   │       └── AuthController.php     (Proses Login multi-role & Logout)
│   │
│   └── Services/                      <-- Data terpusat & bisnis logika
│       └── PortalDataService.php      (Pusat data sekolah, nilai siswa, jadwal, & dewan guru)
│
├── public/                            <-- File aset statis publik
│   ├── assets/
│   │   ├── css/
│   │   │   ├── style.css              (Styling kustom, tema navy/gold/cyan & badge)
│   │   │   └── print.css              (Styling cetak lembar nilai/rapor resmi)
│   │   ├── js/
│   │   │   └── main.js                (Toggle password, filter interaktif, demo autofill)
│   │   └── img/
│   │       └── logo.svg               (Logo resmi vektor SMP Negeri 3)
│   ├── index.php                      (Front controller Laravel)
│   └── .htaccess
│
├── resources/
│   └── views/                         <-- Tampilan antarmuka (Blade Template)
│       ├── layouts/                   (Template induk & kerangka global)
│       │   ├── app.blade.php          (Master layout dengan Navbar & Footer untuk halaman umum)
│       │   ├── auth.blade.php         (Layout khusus login tanpa Navbar & Footer)
│       │   ├── navbar.blade.php       (Header navigasi & tombol login portal)
│       │   └── footer.blade.php       (Footer informasi sekolah & tautan)
│       │
│       ├── pages/                     (Halaman utama per fitur)
│       │   ├── home.blade.php         (Beranda: Hero, statistik, pencarian cepat, pengumuman)
│       │   ├── tentang.blade.php      (Tentang Kami: Kepsek, Visi, Misi, Sejarah, Fasilitas)
│       │   ├── hasil-ujian.blade.php  (Hasil Ujian: Cari NISN, rekapitulasi nilai, status KKM)
│       │   ├── hasil-ujian-cetak.blade.php (Cetak transkrip/rapor resmi dengan kop surat)
│       │   ├── jadwal-ujian.blade.php (Jadwal Ujian: Filter kelas 7/8/9, sesi, ruang, pengawas)
│       │   ├── guru.blade.php         (Dewan Guru: Filter mata pelajaran, kontak, NIP)
│       │   └── login.blade.php        (Halaman Login Mandiri)
│       │
│       └── components/                (Komponen modular yang dapat dipakai ulang)
│           └── notification.blade.php (Notifikasi flash message sukses/error)
│
├── routes/
│   └── web.php                        (Definisi rute URL yang bersih & terorganisir)
│
├── index.php                          (Auto-forwarder untuk akses langsung di Laragon)
└── .htaccess                          (URL rewrite Apache)
```

---

## 🌐 Navigasi & Menu Website

1. **Beranda (`/`)**
   - Banner sambutan & kolom pencarian cepat nilai menggunakan NISN
   - Statistik sekolah (Siswa aktif, Dewan guru, Tingkat kelulusan, Akreditasi A)
   - Kartu akses menu utama
   - Pengumuman akademik terkini
   - Jadwal ujian terdekat & cuplikan dewan guru

2. **Tentang Kami (`/tentang-kami`)**
   - Sambutan resmi Kepala Sekolah
   - Visi & Misi SMP Negeri 3
   - Napak tilas dan sejarah perkembangan sekolah
   - Sarana & Prasarana (Lab Komputer, Lab IPA, Gelanggang Olahraga, dll.)
   - Piagam Akreditasi "A" BAN-S/M

3. **Hasil Ujian (`/hasil-ujian`)**
   - Pencarian berdasarkan NISN, NIS, atau Nama Siswa
   - Filter berdasarkan tingkat kelas (Kelas 7, 8, 9 atau spesifik 7-A, 8-B, dll.)
   - Kartu metrik hasil ujian: Rata-rata Nilai, Peringkat Kelas, Status Remedial
   - Tabel detail nilai mata pelajaran (Tugas, UTS, UAS, Nilai Akhir, Predikat, Status KKM)
   - Tombol **Cetak Rapor** untuk membuka lembar transkrip resmi siap cetak / simpan PDF (`/hasil-ujian/cetak/{nisn}`)

4. **Jadwal Ujian (`/jadwal-ujian`)**
   - Tab filter tingkat kelas: Semua, Kelas 7, Kelas 8, Kelas 9
   - Informasi detail: Hari, Tanggal, Waktu (WIB), Ruangan, Pengawas Ujian, dan Jenis Ujian (PAS, CBT, Try Out)
   - Kotak peringatan tata tertib peserta ujian
   - Tombol cetak jadwal ujian

5. **Dewan Guru (`/guru`)**
   - Pencarian guru berdasarkan nama, mata pelajaran, atau NIP
   - Tombol filter kategori mata pelajaran (Matematika, IPA, Bahasa Indonesia, dll.)
   - Kartu profil dewan guru dengan jabatan, NIP, pendidikan terakhir, masa mengabdi, dan tautan email

6. **Halaman Khusus Login Dewan Guru (`/login`)**
   - Tombol **Login Guru** di navbar langsung mengarahkan ke halaman login mandiri terpisah (tanpa popup)
   - Tampilan bersih **tanpa navbar dan footer umum**, menggunakan layout khusus `resources/views/layouts/auth.blade.php`
   - Tersedia tombol pintas **"Kembali ke Beranda"** di bagian atas kartu
   - Dikhususkan bagi dewan guru dengan input **Nomor Induk Pegawai (NIP)** dan Kata Sandi
   - Siswa & orang tua dapat langsung memeriksa nilai pada menu publik **Hasil Ujian** tanpa login

---

## 🚀 Cara Menjalankan Website di Laragon

### Opsi 1: Menggunakan Apache Laragon Langsung
1. Pastikan server Apache di Laragon sudah dalam keadaan **Start**.
2. Buka browser dan kunjungi salah satu URL berikut:
   - `http://portalnilai-smp3.test` (jika virtual host otomatis Laragon aktif)
   - atau `http://localhost/portalnilai-smp3`

### Opsi 2: Menggunakan Artisan Serve
1. Buka terminal di folder `E:\laragon\www\portalnilai-smp3`
2. Jalankan perintah:
   ```bash
   php artisan serve
   ```
3. Buka browser pada alamat `http://127.0.0.1:8000`

---

## 🔑 Contoh Kredensial Guru untuk Pengujian

Untuk mencoba login guru, dapat menggunakan NIP dewan guru yang terdaftar:
- **Hendro Prasetyo, M.Pd. (Guru Matematika):** NIP `19800820 200501 1 008` (atau `198008202005011008`) | Sandi: `guru123`
- **Siti Rahmawati, S.Pd. (Guru Bhs Indonesia / Wali 7-A):** NIP `19850410 200902 2 005` | Sandi: `guru123`
- Atau NIP/nama guru lainnya yang terdaftar di halaman Dewan Guru.
