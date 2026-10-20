<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Worklist Radiologi - SatuSehat</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy-950: #020617;
            --navy-900: #0f172a;
            --navy-800: #1e293b;
            --navy-700: #334155;
            --accent: #3b82f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top left, #0b1220 0%, #020617 60%);
            color: #e2e8f0;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-navy {
            background: rgba(15, 23, 42, .85);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid #1e293b;
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(59, 130, 246, .35);
        }

        /* Card */
        .glass-card {
            background: rgba(30, 41, 59, .55);
            backdrop-filter: blur(12px);
            border: 1px solid #1e293b;
            border-radius: 14px;
        }

        /* Form controls */
        .form-control,
        .form-select {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            color: #e2e8f0 !important;
            border-radius: 8px;
            font-size: .875rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .25) !important;
        }

        .form-control::placeholder {
            color: #64748b !important;
        }

        /* Stat cards */
        .stat-card {
            background: rgba(30, 41, 59, .55);
            border: 1px solid #1e293b;
            border-radius: 12px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card .stat-label {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #94a3b8;
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* Table */
        .table-navy {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: .85rem;
        }

        .table-navy thead th {
            background: rgba(15, 23, 42, .9);
            color: #94a3b8;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            font-weight: 600;
            padding: 12px 14px;
            border-bottom: 1px solid #1e293b;
            white-space: nowrap;
        }

        .table-navy tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid #1e293b;
            vertical-align: middle;
            color: #cbd5e1;
        }

        .table-navy tbody tr:hover {
            background: rgba(30, 64, 175, .1);
        }

        .table-navy tbody tr:last-child td {
            border-bottom: none;
        }

        .cell-strong {
            color: #f1f5f9;
            font-weight: 500;
        }

        .cell-muted {
            color: #94a3b8;
            font-size: .8rem;
        }

        .cell-mono {
            font-family: ui-monospace, monospace;
            color: #93c5fd;
        }

        /* Badge */
        .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 500;
        }

        .badge-soft .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-green {
            background: rgba(16, 185, 129, .12);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, .25);
        }

        .badge-green .dot {
            background: #34d399;
        }

        .badge-red {
            background: rgba(239, 68, 68, .12);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, .25);
        }

        .badge-red .dot {
            background: #f87171;
        }

        .badge-blue {
            background: rgba(59, 130, 246, .12);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, .25);
        }

        .badge-blue .dot {
            background: #60a5fa;
        }

        /* Buttons */
        .btn-navy-primary {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            border: none;
            color: #fff;
            font-weight: 500;
            border-radius: 8px;
            font-size: .85rem;
            transition: all .2s;
        }

        .btn-navy-primary:hover {
            box-shadow: 0 0 20px rgba(59, 130, 246, .5);
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-navy-secondary {
            background: #1e293b;
            border: 1px solid #334155;
            color: #cbd5e1;
            font-weight: 500;
            border-radius: 8px;
            font-size: .85rem;
        }

        .btn-navy-secondary:hover {
            background: #334155;
            color: #fff;
        }

        .btn-icon {
            padding: 5px 9px;
            border-radius: 7px;
            font-size: .78rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all .15s;
            border: 1px solid transparent;
        }

        .btn-icon.cek {
            background: rgba(59, 130, 246, .1);
            color: #60a5fa;
            border-color: rgba(59, 130, 246, .25);
        }

        .btn-icon.cek:hover {
            background: rgba(59, 130, 246, .25);
            color: #fff;
        }

        .btn-icon.kirim {
            background: rgba(239, 68, 68, .1);
            color: #f87171;
            border-color: rgba(239, 68, 68, .25);
        }

        .btn-icon.kirim:hover {
            background: rgba(239, 68, 68, .25);
            color: #fff;
        }

        .btn-icon.copy {
            background: #1e293b;
            color: #cbd5e1;
            border-color: #334155;
        }

        .btn-icon.copy:hover {
            background: #334155;
            color: #fff;
        }

        /* Table wrapper scroll */
        .table-wrap {
            overflow-x: auto;
            border-radius: 12px;
        }

        .table-wrap::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrap::-webkit-scrollbar-track {
            background: #0f172a;
            border-radius: 4px;
        }

        .table-wrap::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        /* Empty state */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-state svg {
            opacity: .3;
            margin-bottom: 12px;
        }

        /* Pagination dark theme */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
            font-size: .8rem;
        }

        .page-link:hover {
            background-color: #1e293b !important;
            color: #fff !important;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #2563eb, #4f46e5) !important;
            border-color: #2563eb !important;
            color: #fff !important;
        }

        .page-item.disabled .page-link {
            background-color: #0f172a !important;
            color: #475569 !important;
        }

        /* Search box */
        .search-wrap {
            position: relative;
        }

        .search-wrap .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
            font-size: .9rem;
        }

        .search-wrap .form-control {
            padding-left: 34px;
            padding-right: 34px;
            height: 36px;
            /* lebih ringkas di header tabel */
            font-size: .82rem;
        }

        .search-wrap .search-clear {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 1rem;
            line-height: 1;
            padding: 2px 6px;
            border-radius: 6px;
            cursor: pointer;
            transition: all .15s;
        }

        .search-wrap .search-clear:hover {
            color: #fff;
            background: #334155;
        }

        /* Responsif: di layar kecil search turun ke bawah judul */
        @media (max-width: 576px) {
            .search-wrap {
                min-width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar-navy sticky-top py-3 mb-4">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="brand-logo">
                        <svg width="20" height="20" fill="none" stroke="#fff" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="fw-semibold" style="color:#f1f5f9; font-size:.95rem; line-height:1.1;">
                            Image Study SatuSehat
                        </div>
                        <div style="color:#94a3b8; font-size:.72rem;">Worklist Radiologi</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2" style="color:#94a3b8; font-size:.78rem;">
                    <span class="d-inline-block rounded-circle"
                        style="width:8px;height:8px;background:#34d399;box-shadow:0 0 8px #34d399;"></span>
                    Online
                </div>
            </div>
        </div>
    </nav>

    <div class="container pb-5">

        <!-- Filter -->
        <form method="GET" class="glass-card p-3 mb-4" id="filterForm">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="stat-label d-block mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $start }}">
                </div>
                <div class="col-md-3">
                    <label class="stat-label d-block mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $end }}">
                </div>
                <div class="col-md-2">
                    <label class="stat-label d-block mb-1">Status Kirim</label>
                    <select name="status_kirim" class="form-select">
                        <option value="all" {{ $statusKirim == 'all' ? 'selected' : '' }}>Semua Data</option>
                        <option value="1" {{ $statusKirim == '1' ? 'selected' : '' }}>Sudah Kirim</option>
                        <option value="0" {{ $statusKirim == '0' ? 'selected' : '' }}>Belum Kirim</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-navy-primary w-100 py-2">Terapkan Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ url()->current() }}" class="btn btn-navy-secondary w-100 py-2">Reset</a>
                </div>
            </div>
            {{-- hidden input untuk search agar tetap terkirim saat form filter disubmit --}}
            <input type="hidden" name="search" id="searchHidden" value="{{ $search }}">
        </form>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Total Data</div>
                        <div class="stat-value" style="color:#f1f5f9;">{{ $total }}</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(59,130,246,.12);color:#60a5fa;">
                        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Sudah Dikirim</div>
                        <div class="stat-value" style="color:#34d399;">{{ $sudahDikirim }}</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(16,185,129,.12);color:#34d399;">
                        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Belum Dikirim</div>
                        <div class="stat-value" style="color:#f87171;">{{ $belumDikirim }}</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(239,68,68,.12);color:#f87171;">
                        <svg width="22" height="22" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="glass-card">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3"
                style="border-bottom:1px solid #1e293b;">
                <h6 class="mb-0 fw-semibold" style="color:#f1f5f9; font-size:.9rem;">
                    Daftar Worklist Radiologi
                    @if ($search !== '')
                        <span class="badge-soft badge-blue ms-2" style="font-size:.7rem;">
                            <span class="dot"></span>Filter: "{{ $search }}"
                        </span>
                    @endif
                </h6>

                <div class="d-flex align-items-center gap-2" style="min-width:280px;">
                    {{-- Search box --}}
                    <div class="search-wrap" style="flex:1 1 auto;">
                        <span class="search-icon">🔍</span>
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Cari No Rontgen, Nama, No RM, Pemeriksaan..." value="{{ $search }}"
                            autocomplete="off">
                        @if ($search !== '')
                            <button type="button" class="search-clear" id="searchClear"
                                title="Hapus pencarian">✕</button>
                        @endif
                    </div>
                    <span class="cell-muted" style="font-size:.78rem; white-space:nowrap;">
                        {{ $paginator->total() }} baris
                    </span>
                </div>
            </div>

            <div class="table-wrap">
                <table class="table-navy mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Order</th>
                            <th>No Rontgen</th>
                            <th>Nama Pasien / No RM</th>
                            <th>Pemeriksaan</th>
                            <th>Dokter Pengirim</th>
                            <th>Status Kirim</th>
                            <th>Image Study</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                            @php
                                $rowNumber = ($paginator->currentPage() - 1) * $paginator->perPage() + $index + 1;
                            @endphp
                            <tr>
                                <td class="cell-muted">{{ $rowNumber }}</td>
                                <td class="cell-strong">{{ $row['tanggal_order'] ?? '-' }}</td>

                                <!-- No Rontgen + Copy -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if (($row['processed_status'] ?? 0) == 1)
                                            <span class="badge-soft badge-blue">
                                                <span class="dot"></span>{{ $row['no_rontgen'] }}
                                            </span>
                                        @else
                                            <span class="badge-soft badge-red">
                                                <span class="dot"></span>{{ $row['no_rontgen'] }}
                                            </span>
                                        @endif
                                        <button type="button" class="btn-icon copy copy-btn"
                                            data-copy="{{ $row['no_rontgen'] }}" data-index="{{ $index }}"
                                            title="Salin No Rontgen & Kirim ke API">
                                            📋
                                        </button>
                                    </div>
                                </td>

                                <td>
                                    <div class="cell-strong">{{ $row['nama_pasien'] ?? '-' }}</div>
                                    <div class="cell-mono" style="font-size:.75rem;">{{ $row['no_rm'] ?? '-' }}</div>
                                </td>

                                <td class="cell-strong">{{ $row['nama_pemeriksaan'] ?? '-' }}</td>
                                <td class="cell-strong">{{ $row['dokter_pengirim'] ?? '-' }}</td>

                                <td>
                                    @if (($row['processed_status'] ?? 0) == 1)
                                        <span class="badge-soft badge-green"><span class="dot"></span>Sudah</span>
                                    @else
                                        <span class="badge-soft badge-red"><span class="dot"></span>Belum</span>
                                    @endif
                                </td>

                                <td>
                                    @if (($row['imgstudy_status'] ?? 0) == 1)
                                        <span class="badge-soft badge-green"><span class="dot"></span>Sudah</span>
                                    @else
                                        <span class="badge-soft badge-red"><span class="dot"></span>Belum</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn-icon cek sync-btn"
                                            data-no-rontgen="{{ $row['no_rontgen'] }}" title="Cek Image Study">
                                            🔄 Cek
                                        </button>
                                        <button type="button" class="btn-icon kirim sync-btn"
                                            data-no-rontgen="{{ $row['no_rontgen'] }}" title="Kirim ke SatuSehat">
                                            📨 Kirim
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <svg width="56" height="56" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <div>Tidak ada data untuk ditampilkan</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($paginator->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-4 py-3"
                        style="border-top:1px solid #1e293b;">
                        <div class="cell-muted" style="font-size:.78rem;">
                            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}
                            dari {{ $paginator->total() }} data
                        </div>
                        <div>
                            {{ $paginator->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Loading Overlay (untuk Cek Image Study) -->
    <div id="loadingOverlay"
        style="display:none; position:fixed; inset:0; background:rgba(2,6,23,.75); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center;">
        <div class="glass-card p-4 text-center" style="min-width:280px;">
            <div class="spinner-border text-primary" role="status" style="width:3rem;height:3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 mb-0" style="color:#cbd5e1; font-size:.85rem;">Cek Image Study...</p>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

        // ====== Loading Overlay ======
        function showLoading() {
            const el = document.getElementById('loadingOverlay');
            el.style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // ====== Toast ======
        function showNotification(message, type = 'success') {
            const colorMap = {
                success: {
                    bg: 'rgba(16,185,129,.95)',
                    icon: '✓'
                },
                danger: {
                    bg: 'rgba(239,68,68,.95)',
                    icon: '✗'
                },
                info: {
                    bg: 'rgba(59,130,246,.95)',
                    icon: 'ℹ'
                },
            };
            const c = colorMap[type] || colorMap.info;
            const n = document.createElement('div');
            n.style.cssText = `
                position:fixed; top:20px; right:20px; z-index:10000;
                background:${c.bg}; color:#fff; padding:12px 18px; border-radius:10px;
                min-width:280px; box-shadow:0 10px 30px rgba(0,0,0,.4);
                font-size:.85rem; font-family:'Inter',sans-serif;
                opacity:0; transform:translateY(-10px); transition:all .25s;
            `;
            n.innerHTML = `<strong>${c.icon}</strong>&nbsp;&nbsp;${message}`;
            document.body.appendChild(n);
            requestAnimationFrame(() => {
                n.style.opacity = '1';
                n.style.transform = 'translateY(0)';
            });
            setTimeout(() => {
                n.style.opacity = '0';
                n.style.transform = 'translateY(-10px)';
                setTimeout(() => n.remove(), 300);
            }, 3000);
        }

        // ====== KIRIM ke endpoint baru via backend Laravel ======
        async function callApi(noRontgen, button) {
            // URL log yang ditampilkan saat loading
            const logUrl = `http://192.168.10.135:9090/kirimdata/123312/1/${noRontgen}`;

            // SweetAlert loading + tampilkan log URL
            Swal.fire({
                title: 'Mengirim data...',
                html: `
                    <div style="text-align:left; font-size:.8rem; font-family:ui-monospace,monospace; word-break:break-all;">
                        <p style="color:#94a3b8; margin-bottom:6px;">Log:</p>
                        <p style="color:#60a5fa; margin:0;">${logUrl}</p>
                    </div>
                `,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const originalText = button.innerHTML;
            button.innerHTML = '⏳';
            button.disabled = true;

            try {
                const response = await fetch("{{ route('worklist.kirim') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        no_rontgen: noRontgen
                    })
                });

                const json = await response.json();

                if (json.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: `
                            <p style="margin-bottom:8px;">${json.message}</p>
                            <p style="font-family:ui-monospace,monospace; font-size:.75rem; color:#64748b; word-break:break-all; margin:0;">
                                ${json.url}
                            </p>
                        `,
                        confirmButtonColor: '#2563eb'
                    }).then(() => location.reload());

                    button.innerHTML = '✓';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: `
                            <p style="margin-bottom:8px;">${json.message}</p>
                            <p style="font-family:ui-monospace,monospace; font-size:.75rem; color:#64748b; word-break:break-all; margin:0;">
                                ${json.url || logUrl}
                            </p>
                        `,
                        confirmButtonColor: '#dc2626'
                    });

                    button.innerHTML = '❌';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: `
                        <p style="margin-bottom:8px;">${error.message}</p>
                        <p style="font-family:ui-monospace,monospace; font-size:.75rem; color:#64748b; word-break:break-all; margin:0;">
                            ${logUrl}
                        </p>
                    `,
                    confirmButtonColor: '#dc2626'
                });
                button.innerHTML = '❌';
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 2000);
            }
        }

        // ====== Cek Image Study (endpoint lama 192.168.10.29) ======
        async function syncImageStudy(noRontgen, button) {
            const apiUrl =
                `http://192.168.10.29/wslokal/satusehat/radiologi/worklist/ris/accno/${noRontgen}/sinkimgstudy`;
            showLoading();
            const originalText = button.innerHTML;
            button.innerHTML = '⏳';
            button.disabled = true;

            try {
                const response = await fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                let result;
                try {
                    result = await response.json();
                } catch {
                    result = {
                        message: await response.text()
                    };
                }

                const code = result.metaData?.code;
                const message = result.metaData?.message ||
                    (code === '200' ? `Image Study berhasil untuk No Rontgen: ${noRontgen}` :
                        `Image Study gagal untuk No Rontgen: ${noRontgen}`);

                if (response.ok && code === '200') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: message,
                        timer: 2500,
                        showConfirmButton: true,
                        confirmButtonColor: '#2563eb'
                    });
                    showNotification(message, 'success');
                    button.innerHTML = '✓';
                    setTimeout(() => {
                        location.reload();
                    }, 1800);
                } else if (code === '201') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Info!',
                        text: message,
                        timer: 2500,
                        showConfirmButton: true,
                        confirmButtonColor: '#dc2626'
                    });
                    showNotification(message, 'danger');
                    button.innerHTML = '❌';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                } else {
                    const errorMessage = result.metaData?.message || result.message || 'Gagal cek Image Study';
                    Swal.fire({
                        icon: 'error',
                        title: 'Info!',
                        text: errorMessage,
                        timer: 2500,
                        showConfirmButton: true,
                        confirmButtonColor: '#dc2626'
                    });
                    showNotification(errorMessage, 'danger');
                    button.innerHTML = '❌';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                }
            } catch (error) {
                const errorMsg = error.message || 'Terjadi kesalahan saat cek Image Study';
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: errorMsg,
                    confirmButtonColor: '#dc2626'
                });
                showNotification(errorMsg, 'danger');
                button.innerHTML = '❌';
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 2000);
            } finally {
                hideLoading();
            }
        }

        // ====== Copy + Kirim ======
        function copyAndSendToApi(text, button) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showSuccess(button);
                    callApi(text, button); // <-- kirim ke endpoint baru
                }).catch(() => fallbackCopy(text, button, true));
            } else {
                fallbackCopy(text, button, true);
            }
        }

        function fallbackCopy(text, button, callApiAfter = false) {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.top = '-9999px';
            document.body.appendChild(ta);
            ta.select();
            ta.setSelectionRange(0, text.length);
            try {
                const ok = document.execCommand('copy');
                if (ok) {
                    showSuccess(button);
                    if (callApiAfter) callApi(text, button);
                } else showError(button);
            } catch {
                showError(button);
            }
            document.body.removeChild(ta);
        }

        function showSuccess(button) {
            const original = button.innerHTML;
            button.innerHTML = '✓';
            button.style.background = 'rgba(16,185,129,.2)';
            button.style.color = '#34d399';
            setTimeout(() => {
                button.innerHTML = original;
                button.style.background = '';
                button.style.color = '';
            }, 1500);
        }

        function showError(button) {
            const original = button.innerHTML;
            button.innerHTML = '❌';
            button.style.background = 'rgba(239,68,68,.2)';
            button.style.color = '#f87171';
            setTimeout(() => {
                button.innerHTML = original;
                button.style.background = '';
                button.style.color = '';
            }, 1500);
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyalin',
                text: 'Silakan copy manual dengan seleksi teks.',
                confirmButtonColor: '#dc2626'
            });
        }

        // ====== Event: Copy ======
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const text = this.getAttribute('data-copy');
                if (text && text.trim() !== '') {
                    copyAndSendToApi(text, this);
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Tidak ada teks untuk disalin',
                        confirmButtonColor: '#f59e0b'
                    });
                }
            });
        });

        // ====== Event: Cek / Kirim ======
        document.querySelectorAll('.sync-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const no = this.getAttribute('data-no-rontgen');
                if (!no || no.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Nomor Rontgen tidak valid',
                        confirmButtonColor: '#f59e0b'
                    });
                    return;
                }
                if (this.classList.contains('cek')) {
                    syncImageStudy(no, this); // cek image study (endpoint lama)
                } else {
                    callApi(no, this); // kirim (endpoint baru 135:9090)
                }
            });
        });
        // ====== Search: debounce + auto submit + clear ======
        (function() {
            const form = document.getElementById('filterForm');
            const input = document.getElementById('searchInput');
            const hidden = document.getElementById('searchHidden');
            const clear = document.getElementById('searchClear');
            if (!form || !input) return;

            let timer = null;

            function submitSearch() {
                // sinkronkan nilai search ke hidden input di dalam form
                if (hidden) hidden.value = input.value;
                // reset ke halaman 1 saat search berubah
                let pageInput = form.querySelector('input[name="page"]');
                if (!pageInput) {
                    pageInput = document.createElement('input');
                    pageInput.type = 'hidden';
                    pageInput.name = 'page';
                    form.appendChild(pageInput);
                }
                pageInput.value = 1;
                form.submit();
            }

            // Auto-submit setelah 500ms idle (debounce)
            input.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(submitSearch, 500);
            });

            // Enter langsung submit
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(timer);
                    submitSearch();
                }
            });

            // Tombol clear
            if (clear) {
                clear.addEventListener('click', function() {
                    input.value = '';
                    if (hidden) hidden.value = '';
                    submitSearch();
                });
            }

            // Fokus otomatis jika ada search aktif
            @if ($search !== '')
                input.focus();
                input.setSelectionRange(input.value.length, input.value.length);
            @endif
        })();
    </script>

</body>

</html>
