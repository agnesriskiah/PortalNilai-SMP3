<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru & Tenaga - Administrator IT</title>

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
        .stat-card-clean {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.15rem 1.25rem;
            transition: all 0.2s ease;
        }
        .stat-card-clean:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
        }
        .table-clean thead th {
            font-size: 0.72rem;
            letter-spacing: 0.04em;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 1rem;
        }
        .table-clean tbody td {
            padding: 0.9rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }
        .table-clean tbody tr:hover {
            background-color: #f8fafc;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            transition: all 0.15s ease;
        }
        .action-btn:hover {
            background: #f1f5f9;
            color: #1e3a8a;
            border-color: #cbd5e1;
        }
        .action-btn.delete-btn:hover {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Sidebar Admin Component (Tidak diubah) -->
    @include('komponen_admin.sidebar_admin')

    <!-- Content Area -->
    <div class="content-area">
        <!-- Header Page -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Data Guru & Tenaga Kependidikan</h4>
                <p class="text-muted small mb-0">Kelola profil pengajar, mata pelajaran yang diampu, serta akses akun guru.</p>
            </div>
            <div>
                <a href="{{ route('admin.guru.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Guru</span>
                </a>
            </div>
        </div>

        <!-- Flash Notification -->
        @include('components.notification')

        <!-- Ringkasan Statistik Minimalis -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-clean">
                    <div class="text-muted small fw-medium text-uppercase mb-1" style="font-size: 0.72rem;">Dewan Guru</div>
                    <div class="d-flex align-items-baseline gap-2">
                        <span class="fs-3 fw-bold text-dark">{{ $stats['total_guru'] }}</span>
                        <span class="text-muted small">Orang</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-clean">
                    <div class="text-muted small fw-medium text-uppercase mb-1" style="font-size: 0.72rem;">Mata Pelajaran</div>
                    <div class="d-flex align-items-baseline gap-2">
                        <span class="fs-3 fw-bold text-dark">{{ $stats['total_mapel'] }}</span>
                        <span class="text-muted small">Bidang Studi</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-clean">
                    <div class="text-muted small fw-medium text-uppercase mb-1" style="font-size: 0.72rem;">Administrator</div>
                    <div class="d-flex align-items-baseline gap-2">
                        <span class="fs-3 fw-bold text-dark">{{ $stats['total_admin'] }}</span>
                        <span class="text-muted small">Akun IT</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-clean">
                    <div class="text-muted small fw-medium text-uppercase mb-1" style="font-size: 0.72rem;">Total Terdaftar</div>
                    <div class="d-flex align-items-baseline gap-2">
                        <span class="fs-3 fw-bold text-dark">{{ $stats['total_semua'] }}</span>
                        <span class="text-success small fw-medium"><i class="bi bi-check-circle me-1"></i>Database Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card: Filter & Tabel Terpadu -->
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden" style="border: 1px solid #e2e8f0 !important;">
            <!-- Toolbar Pencarian & Filter -->
            <div class="p-3 px-4 border-bottom bg-white">
                <form action="{{ route('admin.guru') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm border-start-0 ps-1 rounded-end" placeholder="Cari nama, NIP, atau mata pelajaran...">
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3">
                        <select name="mapel" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="Semua">Semua Mata Pelajaran</option>
                            @foreach($daftarMapel as $m)
                                @if($m !== 'Semua')
                                    <option value="{{ $m }}" {{ $selectedMapel === $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-4 col-md-2">
                        <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="Semua" {{ $selectedRole === 'Semua' ? 'selected' : '' }}>Semua Role</option>
                            <option value="guru" {{ $selectedRole === 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="admin" {{ $selectedRole === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="col-sm-4 col-md-2 d-flex gap-1 justify-content-end">
                        <button type="submit" class="btn btn-sm btn-outline-primary px-3 rounded-2 fw-medium">
                            Terapkan
                        </button>
                        @if(!empty($search) || $selectedMapel !== 'Semua' || $selectedRole !== 'Semua')
                            <a href="{{ route('admin.guru') }}" class="btn btn-sm btn-light border text-muted px-2 rounded-2" title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Data Guru -->
            <div class="table-responsive">
                <table class="table table-clean align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 50px;">No</th>
                            <th>Guru / Tenaga Pendidik</th>
                            <th>NIP & Kontak</th>
                            <th>Mapel & Jabatan</th>
                            <th>Username</th>
                            <th class="text-center">Role</th>
                            <th class="pe-4 text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarGuru as $index => $item)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ route('admin.guru.foto', $item->id) }}" alt="{{ $item->name }}" width="38" height="38" class="rounded-circle border p-0 bg-light object-fit-cover">
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $item->name }}</div>
                                            <small class="text-muted d-block" style="font-size: 0.78rem;">{{ $item->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-dark">{{ $item->nip ?: '-' }}</div>
                                    <small class="text-muted" style="font-size: 0.78rem;">{{ $item->no_hp ?: '-' }}</small>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark small">{{ $item->mapel ?: '-' }}</div>
                                    <small class="text-muted d-block" style="font-size: 0.78rem;">{{ $item->jabatan ?: '-' }}</small>
                                </td>
                                <td>
                                    <code class="px-2 py-0.5 bg-light text-secondary rounded fw-normal small">{{ $item->username }}</code>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $item->role === 'admin' ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-success-subtle text-success border border-success-subtle' }} px-2 py-1 fw-medium text-uppercase" style="font-size: 0.7rem;">
                                        {{ $item->role }}
                                    </span>
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.guru.edit', $item->id) }}" class="action-btn" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($activeUser->id != $item->id && $activeUser->username !== $item->username)
                                            <button type="button" class="action-btn delete-btn btn-delete-guru"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}"
                                                title="Hapus Guru">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                    <div class="fw-medium">Tidak ada data guru yang cocok.</div>
                                    <small class="text-muted">Coba ubah kata kunci atau bersihkan filter pencarian.</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Info -->
            <div class="p-3 px-4 border-top bg-light bg-opacity-50 d-flex justify-content-between align-items-center small text-muted">
                <span>Total <strong>{{ $daftarGuru->count() }}</strong> data guru & staf</span>
                <span>Portal Akademik SMPN 3 Unggulan</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Sederhana -->
<div class="modal fade" id="modalHapusGuru" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-4 p-2">
            <div class="modal-body text-center p-3">
                <div class="text-danger mb-2">
                    <i class="bi bi-exclamation-circle fs-1"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">Hapus Data Guru?</h6>
                <p class="text-muted small mb-0">Yakin ingin menghapus <strong id="delete_guru_name" class="text-dark"></strong>?</p>
            </div>
            <div class="modal-footer border-0 p-2 justify-content-center gap-2">
                <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                <form id="formHapusGuru" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete-guru');
        const formDelete = document.getElementById('formHapusGuru');
        const deleteGuruName = document.getElementById('delete_guru_name');
        const modalDelete = new bootstrap.Modal(document.getElementById('modalHapusGuru'));

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                formDelete.action = `/admin/guru/${id}`;
                deleteGuruName.textContent = name;

                modalDelete.show();
            });
        });
    });
</script>
</body>
</html>
