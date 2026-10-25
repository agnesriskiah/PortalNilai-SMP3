# Dokumentasi & Log Perubahan Admin - PortalNilai-SMP3

Dokumen ini mencatat seluruh pembaruan, perbaikan bug, dan penambahan fitur pada modul panel **Administrator (Admin)**.

---

## [2026-10-25] Perbaikan & Pembuatan Modul "Manajemen Data Guru & Tenaga"

### 1. Masalah yang Ditemukan
- **Gejala**: Ketika mengklik menu **"Data Guru & Tenaga"** di sidebar admin, pengguna langsung diarahkan keluar panel admin ke halaman publik (`/guru` yang menampilkan `pages.guru` dengan layout publik).
- **Penyebab**:
  - File `resources/views/komponen_admin/sidebar_admin.blade.php` baris 54 menggunakan tautan `route('guru')`.
  - Rute `route('guru')` memanggil `GuruController@index` yang merender view `pages.guru` (katalog publik dewan guru untuk siswa/umum).
  - Belum tersedia rute, controller, dan antarmuka khusus admin untuk manajemen data guru dan staf pendidik.

---

### 2. Rencana & Langkah Perubahan

#### A. Rute Admin Baru (`routes/web.php`)
Menambahkan grup rute admin untuk kelola guru dan tenaga pendidik:
- `GET /admin/guru` (`admin.guru`) : Halaman utama daftar guru & tenaga di panel admin dengan fitur pencarian dan filter mapel.
- `POST /admin/guru` (`admin.guru.store`) : Tambah data guru / akun pengelola baru ke database MySQL (`pengelola`).
- `PUT /admin/guru/{id}` (`admin.guru.update`) : Perbarui data guru (nama, NIP, mapel, jabatan, nomor HP, email, role).
- `DELETE /admin/guru/{id}` (`admin.guru.destroy`) : Hapus data guru dari sistem.

#### B. Controller Admin Guru (`app/Http/Controllers/AdminGuruController.php`)
- Menangani validasi input form (Nama, NIP, Jabatan, Mata Pelajaran, Email, Username, No HP, Role).
- Menyediakan fungsi CRUD terintegrasi ke database MySQL tabel `pengelola`.
- Mengamankan akses hanya untuk user dengan role `admin`.
- Mendukung fitur pencarian instan (nama/NIP) dan filter kategori mata pelajaran.

#### C. Sinkronisasi Data Database (`app/Services/DatabaseInitService.php`)
- Melengkapi seeder dummy agar ke-12 guru dari daftar sekolah tersimpan otomatis ke tabel `pengelola` (MySQL).
- Dengan demikian data guru dapat langsung diubah, ditambah, atau dihapus secara persisten melalui panel admin.

#### D. Tampilan Antarmuka Panel Admin (`resources/views/admin/guru/index.blade.php`)
- Tetap menggunakan template panel admin dengan `@include('komponen_admin.sidebar_admin')`.
- Menampilkan kartu ringkasan statistik (Total Guru, Total Mapel, Akun Aktif, Staf/Pendidik).
- Tabel interaktif daftar guru dengan tombol aksi (Edit, Hapus, Detail Akun).
- Modal Tambah Guru & Modal Edit Guru responsif dengan validasi form.
- Modal Konfirmasi Hapus Data yang aman.
- Notifikasi alert pesan sukses / gagal.

#### E. Pembaruan Sidebar Admin (`resources/views/komponen_admin/sidebar_admin.blade.php`)
- Mengubah tautan menu **Data Guru & Tenaga** dari `route('guru')` menjadi `route('admin.guru')`.
- Memperbarui deteksi status aktif menu: `request()->routeIs('admin.guru*')`.

---

### 3. Log Eksekusi & Status Pengerjaan
- [x] Inisialisasi dokumentasi di `admin.md`
- [x] Implementasi Seeder Guru lengkap di `DatabaseInitService.php` (Semua 12 guru tersimpan di tabel `pengelola`)
- [x] Pembuatan `AdminGuruController.php` (Lengkap dengan index, filter search & mapel, store, update, destroy, proteksi role admin)
- [x] Penambahan rute admin guru di `routes/web.php` (`admin.guru`, `admin.guru.store`, `admin.guru.update`, `admin.guru.destroy`)
- [x] Pembuatan view `resources/views/admin/guru/index.blade.php` (Desain panel admin seragam, 4 kartu statistik, tabel interaktif, modal Tambah, modal Edit, modal Hapus)
- [x] Pembaruan link sidebar admin di `sidebar_admin.blade.php` (`route('admin.guru')`)
- [x] Pengujian fungsionalitas & verifikasi cache Blade template (Status: OK, total pengelola aktif di MySQL = 13 akun)

---

## [2026-10-25] Integrasi Database MySQL ke Tampilan Publik Website (`/guru` dan `/`)

### 1. Masalah yang Ditemukan
- **Gejala**: Guru baru yang berhasil ditambahkan melalui panel admin (misal akun baru "Trivaldo Aminullah") tidak muncul di halaman website publik (`/guru` atau beranda `/`).
- **Penyebab**:
  - Halaman publik (`GuruController` dan `HomeController`) mengambil data dari `PortalDataService::getDaftarGuru()`.
  - Fungsi `getDaftarGuru()` masih membaca data *array hardcoded* (statis) dalam memori PHP, bukan membaca data dinamis dari tabel MySQL `pengelola`.
  - Akibatnya, data guru baru berhasil tersimpan di database MySQL, tetapi halaman web publik tidak menampilkannya karena belum membaca dari database.

---

### 2. Rencana & Langkah Perbaikan
1. **Tambahkan Kolom Penunjang di Database `pengelola` (`DatabaseInitService.php`)**:
   - Menambahkan kolom `pendidikan` dan `pengalaman` pada tabel `pengelola` jika belum ada.
2. **Perbarui Model `Pengelola.php`**:
   - Menambahkan `pendidikan` dan `pengalaman` ke dalam array `$fillable`.
3. **Hubungkan `PortalDataService::getDaftarGuru()` ke Database MySQL**:
   - Mengubah fungsi `getDaftarGuru()` agar memprioritaskan pengambilan data dari `App\Models\Pengelola::where('role', 'guru')` dari tabel MySQL.
   - Mempertahankan array statis sebagai *fallback* otomatis jika koneksi database mengalami gangguan.
   - Menyelaraskan total statistik jumlah dewan guru di `getProfilSekolah()` dengan jumlah akun guru aktif di MySQL.
4. **Perbarui Form Admin Tambah & Edit Guru**:
   - Menambahkan input untuk field `pendidikan` dan `pengalaman` di Modal Tambah Guru & Modal Edit Guru (`index.blade.php` & `AdminGuruController.php`).
5. **Verifikasi & Pengujian**:
   - Memastikan akun "Trivaldo Aminullah" yang baru ditambahkan langsung tampil di halaman `/guru` dan beranda publik.

---

### 3. Log Eksekusi & Status Pengerjaan
- [x] Pencatatan masalah di `admin.md`
- [x] Penambahan kolom `pendidikan` & `pengalaman` di tabel `pengelola` (`DatabaseInitService.php`)
- [x] Pembaruan `$fillable` di `app/Models/Pengelola.php`
- [x] Sinkronisasi data dinamis MySQL pada `PortalDataService::getDaftarGuru()` dan `getProfilSekolah()`
- [x] Penambahan field `pendidikan` & `pengalaman` di `AdminGuruController.php` dan view `admin/guru/index.blade.php`
- [x] Pengujian integrasi live: Terverifikasi data guru baru ("Trivaldo Aminullah") berhasil terbaca dan langsung muncul di katalog publik website (`/guru`).

---

## [2026-10-25] Penambahan Fitur Upload Foto Profil Guru & Tenaga (Private Storage)

### 1. Kebutuhan & Spesifikasi
- **Kebutuhan**: Admin memerlukan input form untuk mengunggah foto profil guru dan tenaga pendidik.
- **Lokasi Penyimpanan**: Foto **wajib disimpan di folder `storage/foto_guru`** (bukan di folder `public`).
- **Kebijakan Akses (Privasi)**: **Jangan tampilkan foto di publik**.
  - Folder `storage/foto_guru` tidak memiliki symlink ke publik.
  - Halaman publik (`/guru` dan beranda `/`) tetap mempertahankan avatar inisial nama yang elegan dan tidak menampilkan foto pribadi guru.
  - Panel Admin dapat melihat preview foto guru melalui rute terlindungi khusus admin (`/admin/guru/foto/{id}`) dengan autentikasi admin yang ketat.

---

### 2. Rencana & Langkah Perubahan

#### A. Rute Terlindungi Khusus Admin (`routes/web.php`)
- `GET /admin/guru/foto/{id}` (`admin.guru.foto`) : Endpoint private streaming gambar dari `storage/foto_guru` khusus bagi admin yang sudah login.

#### B. Controller Admin Guru (`app/Http/Controllers/AdminGuruController.php`)
- Menambahkan method `foto($id)` untuk menyajikan file foto langsung dari `storage/foto_guru` secara aman hanya untuk admin.
- Menambahkan validasi file foto pada method `store()` dan `update()` (`image|mimes:jpeg,png,jpg,webp|max:2048`).
- Mengunggah dan memindahkan file ke `storage_path('foto_guru')`.
- Menghapus file foto lama di `storage/foto_guru` saat dilakukan pembaruan (update) atau penghapusan data guru (`destroy()`).

#### C. Antarmuka Panel Admin Guru (`resources/views/admin/guru/index.blade.php`)
- Menambahkan atribut `enctype="multipart/form-data"` pada form modal tambah dan modal edit guru.
- Menambahkan input file foto pada **Modal Tambah Guru** dan **Modal Edit Guru**.
- Menampilkan thumbnail foto di tabel admin menggunakan rute terlindungi `route('admin.guru.foto', $item->id)`.
- Menyediakan preview foto saat ini pada modal edit.

#### D. Perlindungan Privasi Website Publik
- Memastikan halaman `/guru` dan beranda `/` tidak memuat atau menampilkan foto dari folder storage, tetap menggunakan avatar inisial SVG terstandar.

---

### 3. Log Eksekusi & Status Pengerjaan
- [x] Inisialisasi dokumentasi di `admin.md`
- [x] Penambahan rute terlindungi `admin.guru.foto` di `routes/web.php`
- [x] Implementasi upload, streaming file privat, dan penghapusan foto di `AdminGuruController.php` (Validasi max 2MB, format JPG/PNG/WEBP, auto-clean old files)
- [x] Penambahan input file & `enctype="multipart/form-data"` di `resources/views/admin/guru/index.blade.php` (Modal Tambah & Modal Edit dengan preview)
- [x] Verifikasi penyimpanan file di `storage/foto_guru` dan isolasi dari publik (Website publik `/guru` & `/` tetap memakai inisial avatar; endpoint foto diproteksi khusus Admin)
- [x] Pengujian sintaks route dan Blade view cache (Status: Berhasil / OK)

---

## [2026-10-25] Penyesuaian Tampilan Foto Guru di Website (`/guru` dan `/`)

### 1. Masalah yang Dilaporkan
- **Gejala**: Foto guru yang baru diunggah oleh admin (misal foto untuk akun "Trivaldo Aminullah") belum muncul di halaman website publik.
- **Penyebab**:
  - Tampilan publik (`pages/guru.blade.php` dan `pages/home.blade.php`) sebelumnya hanya memiliki elemen inisial nama tanpa tag `<img>` untuk foto.
  - File foto disimpan di dalam direktori privat `storage/foto_guru` (di luar root web `public/`), sehingga memerlukan rute controller khusus untuk streaming gambar ke browser.

---

### 2. Rencana & Langkah Perbaikan
1. **Rute Publik Foto Guru (`routes/web.php`)**:
   - Menambahkan `GET /guru/foto/{id}` (`guru.foto`) agar gambar dari `storage/foto_guru` dapat disajikan secara aman ke website publik.
2. **Method Streaming di `GuruController.php`**:
   - Menambahkan fungsi `foto($id)` untuk menyajikan file gambar dari `storage_path('foto_guru')` dengan header gambar yang sesuai.
3. **Penyelarasan Data di `PortalDataService.php`**:
   - Menambahkan field `foto_url` pada array guru yang dihasilkan fungsi `getDaftarGuru()`.
4. **Pembaruan Tampilan Website Publik**:
   - Pada `pages/guru.blade.php`: Menampilkan foto guru berbentuk lingkaran presisi dengan border rapi; jika foto belum ada, otomatis menampilkan avatar inisial nama.
   - Pada `pages/home.blade.php`: Menampilkan foto pada kartu cuplikan guru di beranda.
   - Pada `admin/dashboard.blade.php`: Menyelaraskan thumbnail foto agar tidak 404.

---

### 3. Log Eksekusi & Status Pengerjaan
- [x] Pencatatan masalah di `admin.md`
- [x] Penambahan rute `guru.foto` di `routes/web.php`
- [x] Pembuatan method `foto($id)` di `GuruController.php` (Menyajikan file foto dari `storage/foto_guru`)
- [x] Pembaruan `PortalDataService::getDaftarGuru()` (`foto_url`)
- [x] Pembaruan view `pages/guru.blade.php` & `pages/home.blade.php` (Menampilkan foto profil guru secara responsif, fallback inisial jika foto kosong)
- [x] Pembaruan view `admin/dashboard.blade.php`, `komponen_guru/sidebar_guru.blade.php`, dan `komponen_website/navbar.blade.php`
- [x] Pengujian live foto guru "Trivaldo Aminullah": Status HTTP 200 OK, foto berhasil tampil di katalog website publik.

---

## [2026-10-25] Refactoring Modul Guru Admin: Pemisahan View Mandiri (Non-Index & Non-Modal)

### 1. Masalah & Kebutuhan
- **Kebutuhan**:
  - Menghindari penamaan file tunggal `index.blade.php` yang menggabungkan seluruh modal sehingga file menjadi terlalu panjang dan sulit dipelihara.
  - Memisahkan file blade secara modular sesuai fungsinya.
  - Mengubah form input (tambah) dan form edit agar **bukan pop-up (modal)**, melainkan memiliki **halaman mandiri (*dedicated page*)** masing-masing.

---

### 2. Rencana & Langkah Perubahan

#### A. Struktur File View Baru (`resources/views/admin/guru/`)
1. **`daftar_guru.blade.php`**: Khusus menampilkan tabel data guru, ringkasan statistik, filter pencarian & mapel, tombol menuju halaman tambah (`route('admin.guru.create')`), dan tombol edit (`route('admin.guru.edit', $item->id)`).
2. **`tambah_guru.blade.php`**: Halaman mandiri form input data guru baru lengkap dengan upload foto (`storage/foto_guru`), kredensial akun, data akademik, dan tombol navigasi kembali.
3. **`edit_guru.blade.php`**: Halaman mandiri form pembaruan data guru dengan preview foto saat ini dan opsi ganti password.
4. **Hapus File Lama**: Menghapus `resources/views/admin/guru/index.blade.php`.

#### B. Rute Baru (`routes/web.php`)
- `GET /admin/guru` (`admin.guru`): Membuka view `admin.guru.daftar_guru`.
- `GET /admin/guru/tambah` (`admin.guru.create`): Membuka view `admin.guru.tambah_guru`.
- `POST /admin/guru` (`admin.guru.store`): Memproses simpan data guru baru.
- `GET /admin/guru/edit/{id}` (`admin.guru.edit`): Membuka view `admin.guru.edit_guru`.
- `PUT /admin/guru/{id}` (`admin.guru.update`): Memproses pembaruan data guru.
- `DELETE /admin/guru/{id}` (`admin.guru.destroy`): Memproses hapus data guru.
- `GET /admin/guru/foto/{id}` (`admin.guru.foto`): Stream foto dari storage.

#### C. Controller (`AdminGuruController.php`)
- Menambahkan method `create()` untuk merender view `admin.guru.tambah_guru`.
- Menambahkan method `edit($id)` untuk merender view `admin.guru.edit_guru` membawa data guru terkait.
- Memperbarui method `index()` agar merender view `admin.guru.daftar_guru`.

---

### 3. Log Eksekusi & Status Pengerjaan
- [x] Inisialisasi dokumentasi di `admin.md`
- [x] Penambahan rute `admin.guru.create` dan `admin.guru.edit` di `routes/web.php`
- [x] Penambahan method `create()` dan `edit($id)` di `AdminGuruController.php`
- [x] Pembuatan `resources/views/admin/guru/daftar_guru.blade.php` (tabel guru bersih tanpa pop up modal form)
- [x] Pembuatan `resources/views/admin/guru/tambah_guru.blade.php` (halaman mandiri form input data guru & upload foto dengan live preview)
- [x] Pembuatan `resources/views/admin/guru/edit_guru.blade.php` (halaman mandiri form edit data guru & ganti foto dengan preview)
- [x] Penghapusan file lama `resources/views/admin/guru/index.blade.php`
- [x] Verifikasi alur navigasi (daftar -> tambah -> simpan -> daftar / daftar -> edit -> update -> daftar) dan kompilasi Blade (Status: Berhasil / OK)

---

## [2026-10-25] Pembersihan & Penyederhanaan UI Halaman Data Guru & Tenaga

### 1. Kebutuhan & Fokus
- **Tujuan**: Membuat antarmuka pengguna (UI) pada modul Data Guru & Tenaga menjadi lebih bersih, sederhana (*clean & minimalist*), modern, dan tidak berantakan.
- **Batasan**: **Hanya fokus di bagian data guru dan tenaga (`resources/views/admin/guru/`)**. **Sidebar admin tidak diubah**.

---

### 2. Poin Penyederhanaan Desain

#### A. Halaman Daftar Guru (`daftar_guru.blade.php`)
- **Header Ringkas**: Menghilangkan badge berlapis yang berat, digantikan dengan judul yang tegas, deskripsi singkat, dan tombol "Tambah Guru" yang elegan.
- **Kartu Statistik Minimalis**: Didesain flat dengan border halus dan palet warna netral/subtle, menghilangkan background warna yang terlalu mencolok.
- **Toolbar Filter Terpadu**: Form pencarian dan filter mata pelajaran/role disatukan langsung ke dalam header tabel (tanpa card terpisah yang memakan ruang vertikal).
- **Tabel Data Rapi**: Penyesuaian spasi/padding sel tabel, badge role yang halus, serta tombol aksi (Edit & Hapus) yang bersih dan presisi.
- **Modal Konfirmasi Hapus Sederhana**: Modal konfirmasi dibuat kompak dan to-the-point tanpa elemen visual berlebihan.

#### B. Halaman Form Tambah & Edit (`tambah_guru.blade.php` & `edit_guru.blade.php`)
- **Struktur Satu Card Terpadu**: Menggabungkan 3-4 card terpisah menjadi satu card utama yang solid dan kohesif dengan pembatas section (*section divider*) yang elegan.
- **Navigasi Atas Bersih**: Tautan kembali yang simpel dan judul halaman yang informatif.
- **Grup Form 2 Kolom Seimbang**: Pengelompokan field (Identitas & Akademik, Akun & Kontak, serta Foto Profil) yang proporsional dan mudah diisi.
- **Area Foto Profil Ringkas**: Komponen upload foto kompak dengan preview instan dan tombol pilih file yang modern.
- **Footer Aksi Terintegrasi**: Tombol Batal dan Simpan menyatu di bagian bawah kartu form.

---

### 3. Log Eksekusi & Status Pengerjaan
- [x] Inisialisasi dokumentasi di `admin.md`
- [x] Refactor UI `resources/views/admin/guru/daftar_guru.blade.php` (Header simpel, stat card flat & subtle, toolbar filter terpadu dalam 1 tabel card, aksi rapi)
- [x] Refactor UI `resources/views/admin/guru/tambah_guru.blade.php` (Satu card terpadu, layout form 2 kolom proporsional, picker foto ringkas)
- [x] Refactor UI `resources/views/admin/guru/edit_guru.blade.php` (Desain senada, thumbnail foto profil fleksibel, navigasi kembali minimalis)
- [x] Verifikasi: Sidebar admin (`sidebar_admin.blade.php`) tetap utuh tanpa perubahan sama sekali
- [x] Verifikasi kompilasi Blade view cache (Status: Berhasil / OK)










