<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Guru - Administrator IT</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo.svg') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .content-area {
            flex-grow: 1;
            padding: 1.75rem 2.25rem;
            overflow-y: auto;
        }
        .form-section-title {
            font-size: 0.78rem;
            letter-spacing: 0.05em;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .form-control, .form-select {
            border-color: #cbd5e1;
            font-size: 0.9rem;
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }
        .form-label {
            font-size: 0.825rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.35rem;
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Sidebar Admin Component (Tidak diubah) -->
    @include('komponen_admin.sidebar_admin')

    <!-- Content Area -->
    <div class="content-area">
        <!-- Header & Navigasi -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.guru') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-1">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Guru
                </a>
                <h4 class="fw-bold text-dark mb-0">Edit: {{ $guru->name }}</h4>
            </div>
            <div>
                <a href="{{ route('admin.guru') }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-medium">
                    Batal
                </a>
            </div>
        </div>

        <!-- Flash & Error Notification -->
        @include('components.notification')

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4 small" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>
                        <strong>Terdapat input yang belum sesuai:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Single Unified Form Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden p-4 p-md-5" style="border: 1px solid #e2e8f0 !important; max-width: 920px;">
            <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Section 1: Identitas & Akademik -->
                <div class="form-section-title">
                    <i class="bi bi-person me-1"></i> Informasi Identitas & Penugasan
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label class="form-label">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name', $guru->name) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NIP <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $guru->nip) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mata Pelajaran Pengampu</label>
                        <input type="text" name="mapel" list="listMapel" class="form-control" value="{{ old('mapel', $guru->mapel) }}">
                        <datalist id="listMapel">
                            @foreach($daftarMapel as $m)
                                <option value="{{ $m }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jabatan / Tugas Tambahan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $guru->jabatan) }}">
                    </div>

                    <div class="col-md-7">
                        <label class="form-label">Riwayat Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', $guru->pendidikan) }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Pengalaman Mengajar</label>
                        <input type="text" name="pengalaman" class="form-control" value="{{ old('pengalaman', $guru->pengalaman) }}">
                    </div>
                </div>

                <!-- Section 2: Akun Login & Kontak -->
                <div class="form-section-title mt-4">
                    <i class="bi bi-shield-lock me-1"></i> Kredensial Akun & Kontak
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Email Sekolah / Aktif <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email', $guru->email) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor WhatsApp / HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $guru->no_hp) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Username Login <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" required value="{{ old('username', $guru->username) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kata Sandi Baru <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tak diubah">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Hak Akses (Role) <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="guru" {{ old('role', $guru->role) === 'guru' ? 'selected' : '' }}>Dewan Guru</option>
                            <option value="admin" {{ old('role', $guru->role) === 'admin' ? 'selected' : '' }}>Administrator IT</option>
                        </select>
                    </div>
                </div>

                <!-- Section 3: Foto Profil -->
                <div class="form-section-title mt-4">
                    <i class="bi bi-image me-1"></i> Foto Profil Guru
                </div>
                <div class="d-flex align-items-center gap-3 p-3 bg-light bg-opacity-50 rounded-3 border mb-4">
                    <img id="imagePreview" src="{{ route('admin.guru.foto', $guru->id) }}" alt="{{ $guru->name }}" width="56" height="56" class="rounded-circle border p-0 bg-white object-fit-cover shadow-sm">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2">
                            <label class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-medium mb-0" for="inputFoto">
                                <i class="bi bi-upload me-1"></i> Ganti Foto Profil
                            </label>
                            <input type="file" id="inputFoto" name="foto" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                            <span class="text-muted small" id="fileNameLabel">JPG, PNG, WEBP (Maks. 2MB)</span>
                        </div>
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                            Kosongkan jika tidak ingin mengubah foto profil yang tersimpan di <code>storage/foto_guru</code>.
                        </small>
                    </div>
                </div>

                <!-- Footer Aksi -->
                <div class="pt-3 border-top d-flex justify-content-end align-items-center gap-2">
                    <a href="{{ route('admin.guru') }}" class="btn btn-light border rounded-pill px-4 fw-medium">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="bi bi-check-lg"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const inputFoto = document.getElementById('inputFoto');
    const imagePreview = document.getElementById('imagePreview');
    const fileNameLabel = document.getElementById('fileNameLabel');

    inputFoto.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            fileNameLabel.textContent = file.name;
        }
    });
</script>
</body>
</html>
