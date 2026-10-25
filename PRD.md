PRD: Website Manajemen & Tampilan Nilai Siswa SMP Kelas 3 (Kelas 9)
Versi 1.0 | Status: Draft
1. Ringkasan Produk
Website ini adalah sistem informasi nilai akademik untuk siswa SMP kelas 3 (kelas 9). Guru dan admin mengelola data kelas, mata pelajaran, dan nilai. Siswa (dan opsional orang tua) dapat melihat nilai mereka secara online, aman, dan mudah diakses.
2. Latar Belakang & Masalah
• Rekap nilai masih manual (kertas/Excel) sehingga rawan salah input dan hilang.
• Siswa dan orang tua sulit melihat nilai secara cepat.
• Guru butuh satu tempat terpusat untuk input dan rekap nilai.
3. Tujuan
1. Memusatkan seluruh data nilai dalam satu sistem.
2. Mempercepat input dan rekap nilai oleh guru.
3. Memberi siswa akses mudah dan aman ke nilai mereka sendiri.
4. Mengurangi kesalahan input dengan validasi otomatis.
Indikator keberhasilan: semua nilai satu semester terinput di sistem, waktu input nilai satu kelas di bawah 15 menit, siswa dapat melihat nilai tanpa bantuan guru.
4. Pengguna (Role)
Role
Deskripsi
Hak Akses Utama
Admin
Operator sekolah / pengelola sistem
Kelola semua data: akun, kelas, mapel, siswa, nilai
Guru
Pengajar mata pelajaran / wali kelas
Input dan edit nilai untuk mapel dan kelas yang diampu
Siswa
Murid kelas 9
Melihat nilai milik sendiri (hanya baca)
Orang tua (opsional)
Wali siswa
Melihat nilai anak (fase berikutnya)
5. Ruang Lingkup
Termasuk (MVP):
• Login berbasis role
• Manajemen kelas (9A, 9B, 9C, dst.)
• Manajemen mata pelajaran
• Manajemen data siswa
• Input, edit, hapus nilai
• Tampilan nilai untuk siswa
• Rekap nilai dan rata-rata
• Export laporan (PDF/Excel)
Tidak termasuk (fase berikutnya):
• Absensi, pembayaran SPP, jadwal pelajaran
• Aplikasi mobile native
• Notifikasi WhatsApp/email otomatis
6. Alur Pengguna (User Flow)
6.1 Alur Admin
1. Login sebagai Admin.
2. Masuk ke Dashboard Admin (ringkasan jumlah siswa, kelas, guru, mapel).
3. Atur Tahun Ajaran & Semester aktif.
4. Tambah Kelas (contoh: 9A, 9B).
5. Tambah Mata Pelajaran (contoh: Matematika, IPA, Bahasa Indonesia).
6. Tambah Akun Guru, lalu hubungkan guru ke mapel dan kelas yang diampu.
7. Tambah Data Siswa (manual atau impor Excel) dan tempatkan ke kelas.
8. Pantau, edit, atau koreksi nilai bila diperlukan.
9. Export laporan nilai.
6.2 Alur Guru
1. Login sebagai Guru.
2. Dashboard menampilkan daftar kelas dan mapel yang diampu.
3. Pilih Kelas (contoh: 9A).
4. Pilih Mata Pelajaran (contoh: Matematika).
5. Pilih Jenis Penilaian (Tugas, UH, UTS, UAS).
6. Tabel daftar siswa muncul, guru mengisi nilai per siswa (atau impor Excel).
7. Sistem memvalidasi (angka 0 sampai 100, tidak boleh kosong).
8. Simpan. Nilai akhir dan rata-rata dihitung otomatis.
9. Edit nilai bila ada koreksi (tercatat di log perubahan).
10. Lihat rekap dan export laporan kelas.
6.3 Alur Siswa
1. Login memakai NISN/NIS dan password.
2. Dashboard menampilkan profil singkat dan semester aktif.
3. Pilih semester/tahun ajaran.
4. Lihat tabel nilai per mata pelajaran (Tugas, UH, UTS, UAS, Nilai Akhir).
5. Lihat rata-rata dan peringkat (opsional, sesuai kebijakan sekolah).
6. Unduh rapor/transkrip nilai (PDF).
7. Logout.
6.4 Diagram Alur Singkat
Admin: Login → Atur Tahun Ajaran → Buat Kelas → Buat Mapel → Buat Akun Guru → Input Siswa → Plot Guru ke Kelas/Mapel

Guru: Login → Pilih Kelas → Pilih Mapel → Pilih Jenis Nilai → Input Nilai → Simpan → Rekap/Export

Siswa: Login → Pilih Semester → Lihat Nilai → Unduh PDF
7. Kebutuhan Fungsional
7.1 Autentikasi & Otorisasi
• FR-01: Login dengan username/NIS dan password.
• FR-02: Akses dibatasi berdasarkan role.
• FR-03: Reset/ubah password.
• FR-04: Siswa hanya bisa melihat nilai miliknya sendiri.
7.2 Manajemen Kelas
• FR-05: Admin dapat tambah, ubah, hapus kelas.
• FR-06: Setiap kelas terkait tahun ajaran dan wali kelas.
7.3 Manajemen Mata Pelajaran
• FR-07: Admin dapat tambah, ubah, hapus mapel (nama, kode, KKM).
• FR-08: Mapel dihubungkan ke guru pengampu dan kelas.
7.4 Manajemen Siswa
• FR-09: Tambah, ubah, hapus data siswa (NIS, NISN, nama, kelas).
• FR-10: Impor data siswa lewat Excel/CSV.
7.5 Manajemen Nilai
• FR-11: Guru dapat input nilai per siswa, per mapel, per jenis penilaian.
• FR-12: Validasi nilai 0 sampai 100.
• FR-13: Nilai akhir dihitung otomatis dengan bobot yang dapat diatur (contoh: Tugas 20%, UH 20%, UTS 30%, UAS 30%).
• FR-14: Guru hanya bisa mengubah nilai mapel/kelas yang ia ampu.
• FR-15: Admin dapat mengubah semua nilai.
• FR-16: Riwayat perubahan nilai tercatat (siapa, kapan, nilai lama dan baru).
• FR-17: Impor nilai lewat template Excel.
7.6 Tampilan & Laporan
• FR-18: Siswa melihat nilai per mapel, per semester.
• FR-19: Indikator di bawah KKM diberi tanda warna.
• FR-20: Rekap rata-rata per siswa dan per kelas.
• FR-21: Export laporan ke PDF dan Excel.
8. Kebutuhan Non-Fungsional
• Keamanan: password di-hash, HTTPS, proteksi dari SQL injection dan XSS.
• Privasi: nilai siswa tidak boleh bisa dilihat siswa lain.
• Performa: halaman termuat di bawah 3 detik pada koneksi normal.
• Responsif: nyaman dipakai di HP dan desktop.
• Ketersediaan: backup database berkala.
• Kemudahan: antarmuka sederhana agar guru non-teknis mudah memakainya.
9. Rancangan Data (Ringkas)
Tabel
Isi Utama
users
id, username, password, role
tahun_ajaran
id, nama, semester, status aktif
kelas
id, nama kelas, wali kelas, tahun ajaran
siswa
id, user_id, NIS, NISN, nama, kelas_id
mata_pelajaran
id, nama, kode, KKM
pengampu
guru_id, mapel_id, kelas_id
nilai
id, siswa_id, mapel_id, jenis (tugas/UH/UTS/UAS), nilai, semester
log_nilai
id, nilai_id, diubah_oleh, nilai_lama, nilai_baru, waktu
10. Rekomendasi Teknologi
• Frontend: Next.js / React dengan Tailwind CSS
• Backend: Node.js (Express) atau Laravel
• Database: PostgreSQL atau MySQL
• Hosting: VPS atau platform seperti Vercel + database terkelola
Pilihan akhir menyesuaikan kemampuan tim.
11. Halaman yang Dibutuhkan
• Halaman login
• Dashboard Admin, Guru, Siswa
• Kelola Kelas, Mapel, Siswa, Guru (Admin)
• Input/Edit Nilai (Guru dan Admin)
• Rekap Nilai per Kelas
• Lihat Nilai (Siswa)
• Pengaturan profil dan password
12. Rencana Rilis
Fase
Isi
Estimasi
1
Desain UI, struktur database, login
1 sampai 2 minggu
2
Kelola kelas, mapel, siswa, guru
2 minggu
3
Input nilai, hitung nilai akhir, validasi
2 minggu
4
Tampilan siswa, rekap, export PDF/Excel
2 minggu
5
Testing, perbaikan, peluncuran
1 sampai 2 minggu
13. Risiko & Mitigasi
Risiko
Mitigasi
Salah input nilai
Validasi, log perubahan, fitur koreksi
Siswa lupa password
Reset oleh admin/guru
Guru kurang paham teknologi
UI sederhana, panduan singkat, template Excel
Kebocoran data nilai
Pembatasan role, HTTPS, backup
14. Pertanyaan Terbuka
1. Apakah orang tua perlu akun sendiri?
2. Apakah peringkat kelas ditampilkan ke siswa?
3. Berapa bobot penilaian (Tugas, UH, UTS, UAS) yang dipakai sekolah?
4. Apakah perlu fitur rapor lengkap dengan catatan wali kelas?
5. Pesan Anda terpotong di bagian "beserta juga,". Fitur tambahan apa yang ingin dimasukkan?